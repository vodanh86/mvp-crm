<?php

namespace App\Admin\Controllers;

use App\Models\Plan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class PlanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Plan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plan());
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('duration', __('Duration'));
        $grid->column('price', __('Price'));

        if (Admin::user()->isRole('Editor')){
            /*$grid->disableCreateButton();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });*/
        } else {
        }
        
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
        $show = new Show(Plan::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('duration', __('Duration'));
        $show->field('price', __('Price'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Plan());

        $form->text('name', __('Name'));
        $form->text('description', __('Description'));
        $form->text('duration', __('Duration'));
        $form->text('price', __('Price'));

        return $form;
    }
}
