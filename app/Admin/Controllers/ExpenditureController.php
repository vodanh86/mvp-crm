<?php

namespace App\Admin\Controllers;

use App\Models\Expenditure;
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

        $form->select('type', __('Thu chi'))->options(Constant::EXP_TYPE)->default(1)->setWidth(2, 2)
        ->when(0, function (Form $form) {
            $form->select('sub_type', __('Loại thu'))->options(Constant::IN_TYPE)->default(1)->setWidth(2, 2);
        });
        $form->currency('price', __('Price'))->symbol('VND');
        $form->text('note', __('Note'));

        return $form;
    }
}
