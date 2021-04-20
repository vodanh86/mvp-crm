<?php

namespace App\Admin\Controllers;

use App\Models\Expenditure;
use App\Models\Bill;
use Encore\Admin\Controllers\AdminController;
use App\Admin\Actions\Expenditure\VerifyExpenditure;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ExpenditureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Quản lý thu chi';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Expenditure());

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'))->using(Constant::EXP_TYPE)->filter(Constant::EXP_TYPE);
        $grid->column('sub_type', __('Sub type'))->using(Constant::IN_TYPE)->filter(Constant::IN_TYPE);
        $grid->column('bought_date', __('Ngày mua'))->sortable();
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title);
        });
        $grid->column('note', __('Note'));
        $grid->column('verify', __('Xác nhận'))->action(VerifyExpenditure::class)->filter(Constant::YES_NO_QUESTION);

        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if($actions->row->verify == 1){
                $actions->disableDelete();
                $actions->disableEdit();
            }
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });
        $grid->header(function ($query) {
            $month = date('m');
            // Query the total amount of the order with the paid status
            $data = Bill::groupBy('contract_type')->where("verify",1)->whereMonth("bought_date",$month)->selectRaw('sum(price) as sum, contract_type')->get();
            $html = "";
            $sumIn = 0;
            foreach($data as $pt => $sum){
                $html .= "<tr><td>".Constant::BILL_TYPE[$sum["contract_type"]]."</td><td style='text-align: right;'>".number_format($sum["sum"])."</td></tr>";
                $sumIn += $sum["sum"];
            }

            $html .= "<tr><td>Tổng tiền thu từ thẻ và PT</td><td style='text-align: right;'>".number_format($sumIn)."</td></tr>";

            $data = Expenditure::groupBy('type')->where("verify",1)->whereMonth("bought_date",$month)->selectRaw('sum(price) as sum, type')->get();
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

            $html .= "<tr><td>Tổng tiền còn lại</td><td style='text-align: right;'>".number_format($sumAll)."</td></tr>";
            return "<div style='padding: 10px;'>Tổng tiền tháng ： $month <table style='width:50%'>
            <tr><td>Tên Dịch vụ</td><td style='text-align: right;'>Tổng số thu</td></tr>".$html."</table></div>";
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
        $show = new Show(Expenditure::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('sub_type', __('Sub type'));
        $show->field('note', __('Note'));
        $show->field('verify', __('Verify'));
        $show->panel()
        ->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableList();
            $tools->disableDelete();
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Expenditure());

        $form->select('type', __('Thu chi'))->options(Constant::EXP_TYPE)->default(0)->setWidth(2, 2)
        ->when(0, function (Form $form) {
            $form->select('sub_type', __('Loại thu'))->options(Constant::IN_TYPE)->default(1)->setWidth(2, 2);
        });
        $form->date('bought_date', 'Ngày mua');
        $form->currency('price', __('Price'))->symbol('VND');
        $form->text('note', __('Note'));

        return $form;
    }
}
