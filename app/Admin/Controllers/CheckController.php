<?php

namespace App\Admin\Controllers;

use App\Models\Check;
use App\Models\Contract;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\AuthUser;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Selectable\SelectContract;

class CheckController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Check';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Check());
        $listPts = AuthUser::pluck('name', 'id');
        $grid->column('id', __('Id'));
        $grid->column('contract_id', __('Contract id'));
        $grid->column('contract.code');
        $grid->column('month', __('Tháng'))->filter('like');
        $grid->column('description', __('Description'))->display(function ($pts) use($listPts) {
            $newDes = array();
            foreach($pts as $pt ){
                $pt["pt"] = $listPts[$pt["pt"]];
                $newDes[] = $pt;
            }
            return json_encode($newDes);
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        $grid->filter(function($filter){
            // Remove the default id filter
            $filter->disableIdFilter();
            // Add a column filter
            $filter->like('month', 'Tháng');

            $filter->where(function ($query) {

                $query->whereHas('contract', function ($query) {
                    $query->where('code', 'like', "%{$this->input}%");
                });
            
            }, 'Contract');
        });

        

        $grid->footer(function ($query) {

            // Query the total amount of the order with the paid status
            $data = $query->get();
            $oldCom = array();
            $newCom = array();
            $oldSes = array();
            $newSes = array();
            foreach($data as $datum){
                $contract = $datum["contract"];
                foreach($datum["description"] as $index => $pt){
                    if(!array_key_exists($pt["pt"], $oldCom)){
                        $oldCom[$pt["pt"]] = 0;
                        $oldSes[$pt["pt"]] = 0;
                    } 
                    if(!array_key_exists($pt["pt"], $newCom)){
                        $newCom[$pt["pt"]] = 0;
                        $newSes[$pt["pt"]] = 0;
                    } 
                    if ($contract["type"] == 0) {
                        $oldCom[$pt["pt"]] += $pt["count"] * 80000.0;
                        $oldSes[$pt["pt"]] += $pt["count"];
                    } else {
                        $newCom[$pt["pt"]] += $pt["count"] * $contract["price"] / $contract["days"];
                        $newSes[$pt["pt"]] += $pt["count"];
                    }
                }
            }
            $html = "";
            foreach($oldCom as $pt => $sum){
                $html .= "<tr><td>".AuthUser::find($pt)->name."</td><td style='text-align: right;'>$sum</td><td style='text-align: right;'>".intval($oldSes[$pt])."</td><td style='text-align: right;'>".intval($newSes[$pt])."</td><td style='text-align: right;'><input  onchange='update($pt)' type='text' id='per_$pt' name='lname' value='0'/></td><td style='text-align: right;'><label id='contract_$pt'>".intval($newCom[$pt])."</label></td><td style='text-align: right;'><label id='com_$pt'>0</label></td></tr>";
            }
            return "<script type='text/javascript'>
            function update(pt){
                console.log(document.getElementById('contract_' + pt).innerHTML);
                document.getElementById('com_' + pt).innerHTML = parseFloat(document.getElementById('per_' + pt).value) * parseFloat(document.getElementById('contract_' + pt).innerHTML) / 100;
            }
            </script>
            <div style='padding: 10px;'>Tổng tiền dạy ： <table style='width:100%'>
            <tr><td>Tên Pt</td><td style='text-align: right;'>Tiền dạy cũ</td><td style='text-align: right;'>Số buổi dạy cũ</td><td style='text-align: right;'>Số buổi dạy mới</td><td style='text-align: right;'>Phần trăm nhận</td><td style='text-align: right;'>Tiền dạy mới</td><td style='text-align: right;'>Tiền com dạy</td></tr>".$html."</table></div>";
        });
        $grid->model()->orderBy('id', 'DESC');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Check::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('contract_id', __('Contract id'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Check());
        $form->belongsTo('contract_id', SelectContract::class,'Chọn hợp đồng');
        $form->text('month', __('Tháng'))->default(3);
        $form->table('description', function ($table) {
            $table->select('pt', __('Pt'))->options(AuthUser::all()->pluck('name', 'id'));
            $table->number('count');
        });

        return $form;
    }
}
