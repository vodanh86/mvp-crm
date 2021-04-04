<?php

namespace App\Admin\Controllers;

use App\Models\Contract;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Contract\Checkin;

class ContractController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Contract';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contract());

        $grid->column('id', __('Id'));
        $grid->column('code', __('Code'))->filter("like");
        $grid->column('name', __('Name'));
        $grid->type('Loại')->using(Constant::CONTRACT_TYPE)->filter(Constant::CONTRACT_TYPE);
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title);
        });
        $grid->column('days', __('Days'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->add(new Checkin($actions->row->id));
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
        $show = new Show(Contract::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('code', __('Code'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('days', __('Days'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Contract());

        $form->text('code', __('Code'));
        $form->text('name', __('Name'));
        $form->select('type', __('Loại hợp đồng'))->options(Constant::CONTRACT_TYPE)->default(1)->setWidth(2, 2);
        $form->currency('price', __('Price'))->symbol('VND');
        $form->text('days', __('Days'));

        return $form;
    }
}
