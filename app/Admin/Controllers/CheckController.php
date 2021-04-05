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

        $grid->column('id', __('Id'));
        $grid->column('contract_id', __('Contract id'));
        $grid->column('contract.code')->filter('like');
        $grid->column('month', __('Tháng'))->filter('like');
        $grid->column('description', __('Description'))->display(function ($images) {
            return json_encode($images);
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->footer(function ($query) {

            // Query the total amount of the order with the paid status
            $data = $query->get();
            $oldCom = array();
            $newCom = array();
            foreach($data as $datum){
                $contract = $datum["contract"];
                foreach($datum["description"] as $index => $pt){
                    if(!array_key_exists($pt["pt"], $oldCom)){
                        $oldCom[$pt["pt"]] = 0;
                    } 
                    if(!array_key_exists($pt["pt"], $newCom)){
                        $newCom[$pt["pt"]] = 0;
                    } 
                    if ($contract["type"] == 0) {
                        $oldCom[$pt["pt"]] += $pt["count"] * 80000.0;
                    } else {
                        $newCom[$pt["pt"]] += $pt["count"] * $contract["price"] / $contract["days"];
                    }
                }
            }
            $html = "";
            foreach($oldCom as $pt => $sum){
                $html .= "<tr><td>".AuthUser::find($pt)->name."</td><td>$sum</td><td>".intval($newCom[$pt])."</td></tr>";
            }
            return "<div style='padding: 10px;'>Tổng tiền dạy ： <table style='width:100%'>
            <tr><td>Tên Pt</td><td>Tiền dạy cũ</td><td>Tiền dạy mới</td></tr>".$html."</table></div>";
        });
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

        $form->select('contract_id', __('Contract id'))->options(Contract::all()->pluck('code', 'id'));
        $form->text('month', __('Tháng'))->default(3);
        $form->table('description', function ($table) {
            $table->select('pt', __('Pt'))->options(AuthUser::all()->pluck('name', 'id'));
            $table->number('count');
        });

        return $form;
    }
}
