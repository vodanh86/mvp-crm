<?php

namespace App\Admin\Controllers;

use App\Models\FormalityAdmin;
use App\Models\FormalityLevel;
use App\Models\FormalityArea;
use App\Models\FormalityOps;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FormalityAdminController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FormalityAdmin';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FormalityAdmin());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->formality_level_id('Formality level')->display(function($formalityLevelId) {
            $formalityLevel = FormalityLevel::find($formalityLevelId);
            if($formalityLevel){
                return $formalityLevel->title;
            }
        });
        $grid->formality_ops_id('Formality Ops')->display(function($formalityOpsId) {
            $formalityOps = FormalityOps::find($formalityOpsId);
            if($formalityOps){
                return $formalityOps->name;
            }
        });
        $grid->formality_area_id('Formality Area')->display(function($formalityAreaId) {
            $formalityArea = FormalityArea::find($formalityAreaId);
            if($formalityArea){
                return $formalityArea->name;
            }
        });
        $grid->show('Show')->display(function($show) {
            if (isset($show)){
                return Constant::SHOW_STATUS[$show];
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
        $show = new Show(FormalityAdmin::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('formality_level_id', __('Formality level id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('formality_ops_id', __('Formality ops id'));
        $show->field('formality_area_id', __('Formality area id'));
        $show->field('description', __('Description'));
        $show->field('name', __('Name'));
        $show->field('base', __('Base'));
        $show->field('order', __('Order'));
        $show->field('method', __('Method'));
        $show->field('component', __('Component'));
        $show->field('resolved_time', __('Resolved time'));
        $show->field('object', __('Object'));
        $show->field('result', __('Result'));
        $show->field('requirement', __('Requirement'));
        $show->field('fee', __('Fee'));
        $show->field('attachment', __('Attachment'));
        $show->field('show', __('Show'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FormalityAdmin());

        $form->text('title', __('Title'));
        $form->select('formality_level_id', trans('Formality level'))->options(FormalityLevel::all()
        ->pluck('title','id'))
        ->loads(['formality_area_id', 'formality_ops_id'], 
        [url('api/formalityArea'), url('api/formalityOps')]);
        $form->select('formality_ops_id', __('Formality ops id'))->options(FormalityOps::all()->pluck('name','id'));
        $form->select('formality_area_id', __('Formality area id'))->options(FormalityArea::all()->pluck('name','id'));
        $form->multipleFile('attachment', __('Attachment'));
        $form->switch("show")->states(Constant::SWITCH_STATE);
        $form->ckeditor('description', __('Description'));
        $form->ckeditor('name', __('Name'));
        $form->ckeditor('base', __('Base'));
        $form->ckeditor('order', __('Order'));
        $form->ckeditor('method', __('Method'));
        $form->ckeditor('component', __('Component'));
        $form->ckeditor('resolved_time', __('Resolved time'));
        $form->ckeditor('object', __('Object'));
        $form->ckeditor('result', __('Result'));
        $form->ckeditor('requirement', __('Requirement'));
        $form->ckeditor('fee', __('Fee'));

        return $form;
    }
}
