<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\Models\AuthUser;
use App\Admin\Actions\Post\BatchReplicate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Admin\Extensions\ExcelExpoter;

class CustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Customer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer());
        $grid->column('name', __('Name'))->display(function () {
            return "<a href='customers/" . $this->id . "' style='white-space: pre;'>$this->name</a>";
        })->filter('like')->sortable();
        $grid->column('phone_number', __('Số điện thoại'))->display(function ($title) {
            return "<a href='tel:" . preg_replace('/\s+/', '', $title) . "' style='white-space: pre;'>$title</a>";
        })->filter('like');
        $grid->block_no('Toà nhà')->display(function($show) {
            if (isset($show)){
                return Constant::BLOCK[$show];
            }
        })->filter(Constant::BLOCK)->sortable();
        $grid->telco('Nhà mạng')->display(function($show) {
            if (isset($show)){
                return Constant::TELCO[$show];
            }
        })->filter(Constant::TELCO)->sortable();
        $grid->status('Trạng thái')->display(function($show) {
            return $show;
        })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);

        $grid->source('Nguồn')->display(function($show) {
            if (isset($show)){
                return Constant::SOURCE[$show];
            }
        })->filter(Constant::SOURCE)->sortable();
        $grid->column('setup_at', __('Ngày hẹn'))->sortable()->editable();
        $grid->column('plan', __('Plan'))->editable();
        $grid->column('note', __('Note'))->editable();
        $grid->sale_id('Nhân viên')->display(function($formalityAreaId) {
            $formalityArea = AuthUser::find($formalityAreaId);
            if($formalityArea){
                return $formalityArea->name;
            }
        });
        $grid->column('like', __('Quan tâm'))->editable();

        if (Admin::user()->isRole('Editor')){
            $grid->model()->where('sale_id', '=', Admin::user()->id);
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
        } else {
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new BatchReplicate());
            });
        }
        $grid->model()->orderBy('id', 'DESC');
        $grid->exporter(new ExcelExpoter());
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
        $show = new Show(Customer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('birthday', __('Birthday'));
        $show->field('room_no', __('Room no'));
        $show->field('phone_number', __('Phone number'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('block_no', __('Block no'));
        $show->field('telco', __('Telco'));
        $show->field('status', __('Status'));
        $show->field('setup_at', __('Setup at'));
        $show->field('plan', __('Plan'));
        $show->field('note', __('Ghi chú'));
        $show->field('sale_id', __('Sale id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer());
        /*if (Admin::user()->isRole('Editor')){
            $form->text('name', __('Name'))->readonly();
            $form->datetime('birthday', __('Birthday'))->default(date('Y-m-d H:i:s'))->readonly();
            $form->text('room_no', __('Room no'))->readonly();
            $form->text('phone_number', __('Phone number'))->readonly();
            $form->select('block_no', __('Toà nhà'))->options(Constant::BLOCK)->setWidth(2, 2)->readonly();
            $form->select('telco', __('Nhà mạng'))->options(Constant::TELCO)->setWidth(2, 2)->readonly();
            $form->select('sale_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'))->readonly();
        } else {*/
            $form->text('name', __('Name'));
            $form->datetime('birthday', __('Birthday'))->default(date('Y-m-d H:i:s'));
            $form->text('room_no', __('Room no'));
            $form->text('phone_number', __('Phone number'));
            $form->select('block_no', __('Toà nhà'))->options(Constant::BLOCK)->setWidth(2, 2);
            $form->select('telco', __('Nhà mạng'))->options(Constant::TELCO)->setWidth(2, 2);
            $form->select('sale_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'));
        //}

        $form->text('setup_at', __('Lịch hẹn gặp'));
        $form->text('plan', __('Gói hiện tại'));
        $form->select('source', __('Nguồn khách'))->options(Constant::SOURCE)->setWidth(2, 2);
        $form->text('note', __('Ghi chú'));
        $form->select('status', __('Trạng thái'))->options(Constant::CUSTOMER_STATUS)->setWidth(2, 2);

        return $form;
    }
}
