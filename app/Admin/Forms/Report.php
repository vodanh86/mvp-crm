<?php

namespace App\Admin\Forms;

use App\Models\Bill;
use App\Models\Expenditure;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use App\Admin\Controllers\Constant;

class Report extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Báo cáo thu chi';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $date = strtotime($request->report_at);
        $month = date("m", $date);
        // Query the total amount of the order with the paid status
        if ($request->report_type == 1){
            $label = "<div style='padding: 10px;'>Tổng tiền ngày ： $request->report_at <table style='width:50%'>";
            $data = Bill::groupBy('contract_type')->where("verify",1)->where("bought_date",$request->report_at)->selectRaw('sum(price) as sum, contract_type')->get();
        } else {
            $label = "<div style='padding: 10px;'>Tổng tiền tháng ： $month <table style='width:50%'>";
            $data = Bill::groupBy('contract_type')->where("verify",1)->whereMonth("bought_date",$month)->selectRaw('sum(price) as sum, contract_type')->get();
        }
        $html = "";
        $sumIn = 0;
        foreach($data as $pt => $sum){
            $html .= "<tr><td>".Constant::BILL_TYPE[$sum["contract_type"]]."</td><td style='text-align: right;'>".number_format($sum["sum"])."</td></tr>";
            $sumIn += $sum["sum"];
        }

        $html .= "<tr><td>Tổng tiền thu từ thẻ và PT</td><td style='text-align: right;'>".number_format($sumIn)."</td></tr>";
        if ($request->report_type == 1){
            $data = Expenditure::groupBy('type')->where("verify",1)->where("bought_date",$request->report_at)->selectRaw('sum(price) as sum, type')->get();
        } else {
            $data = Expenditure::groupBy('type')->where("verify",1)->whereMonth("bought_date",$month)->selectRaw('sum(price) as sum, type')->get();
        }
         $sumAll = $sumIn;
        foreach($data as $key => $sum){
            if ($key == 0){
                $sumAll += $sum["sum"];
                $html .= "<tr><td>Tổng tiền thu</td><td style='text-align: right;'>".number_format($sum["sum"])."</td></tr>";
            } else {
                $sumAll -= $sum["sum"];
                $html .= "<tr><td>Tổng tiền chi</td><td style='text-align: right;'>".number_format($sum["sum"])."</td></tr>";
            }
        }

        $html .= "<tr><td>Tổng tiền thu chi trong tháng</td><td style='text-align: right;'><label id='thisMoney'>".number_format($sumAll)."</label></td></tr>";
        if ($request->report_type == 2){
            $html .= "<tr><td>Tổng số dư tháng trước</td><td style='text-align: right;'><input  onchange='update()' type='text' id='money' name='lname' value='0' style='text-align: right'/></td></tr>";
            $html .= "<tr><td>Tổng số dư cuối tháng</td><td style='text-align: right;'><label   id='allMoney' name='lname' value='0'/></td></tr>";
            $html .= "<script type='text/javascript'>
            function update(){
                console.log(document.getElementById('money').innerHTML);
                document.getElementById('allMoney').innerHTML = (parseFloat(document.getElementById('money').value) + parseFloat(document.getElementById('thisMoney').innerHTML.replaceAll(',',''))).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');;
            }
            </script>";
        }


        $html = $label."<tr><td>Tên Dịch vụ</td><td style='text-align: right;'>Tổng số thu</td></tr>".$html."</table></div>";

        return back()->with(['result' => $html]);

    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('report_type', __('Loại báo cáo'))->options(Constant::REPORT_TYPE)->default(1)->setWidth(4, 2);
        $this->date('report_at', 'Thời điểm báo cáo')->default(date("Y/m/d"));
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'name'       => 'John Doe',
            'email'      => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
