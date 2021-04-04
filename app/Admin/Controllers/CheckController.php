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
        $grid->column('description', __('Description'))->display(function ($images) {
            return json_encode($images);
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
