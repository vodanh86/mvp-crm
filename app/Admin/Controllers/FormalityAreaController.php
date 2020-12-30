<?php

namespace App\Admin\Controllers;

use App\Models\FormalityArea;
use App\Models\FormalityLevel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FormalityAreaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FormalityArea';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FormalityArea());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('order', __('Order'));
        $grid->formality_level_id('Formality level')->display(function($formalityLevelId) {
            $formalityLevel = FormalityLevel::find($formalityLevelId);
            if($formalityLevel){
                return $formalityLevel->title;
            }
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
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
        $show = new Show(FormalityArea::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('formality_level_id', __('Formality level id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FormalityArea());

        $form->text('name', __('Name'));
        $form->number('order', __('Order'));
        $form->select('formality_level_id', trans('Formality level'))->options(FormalityLevel::all()->pluck('title','id'))->setWidth(4, 2);

        return $form;
    }
}
