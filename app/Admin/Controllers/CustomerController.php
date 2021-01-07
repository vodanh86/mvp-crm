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
use App\Admin\Actions\Customer\StarCustomer;


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
        })->filter('like')->sortable()->setAttributes(['width' => ' 240px']);
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
        })->filter(Constant::TELCO)->sortable()->hide();
        if ( Admin::user()->isAdministrator()) {
            $grid->status('Trạng thái')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);

            $grid->pt_status('Trạng thái PT')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);
            
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new BatchReplicate());
            });
        } elseif (Admin::user()->isRole('Editor')){
            $grid->model()->where('sale_id', '=', Admin::user()->id);
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });

            $grid->status('Trạng thái')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);
        } elseif (Admin::user()->isRole('Pt')){
            $grid->model()->where('sale_id', '=', Admin::user()->id);
            $grid->model()->where('status', '=', 4);
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });

            $grid->pt_status('Trạng thái PT')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);
        } elseif (Admin::user()->isRole('Fm')){
            $grid->model()->where('status', '=', 4);

            $grid->pt_status('Trạng thái PT')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);
        } 
        else {
            $grid->status('Trạng thái')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);

            $grid->pt_status('Trạng thái PT')->display(function($show) {
                return $show;
            })->filter(Constant::CUSTOMER_STATUS)->sortable()->editable('select', Constant::CUSTOMER_STATUS);
            
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new BatchReplicate());
            });
        }
        $grid->source('Nguồn')->display(function($show) {
            if (isset($show)){
                return Constant::SOURCE[$show];
            }
        })->filter(Constant::SOURCE)->sortable();
        $grid->column('setup_at', __('Ngày hẹn'))->sortable()->editable();
        $grid->column('plan', __('Plan'))->editable();
        $grid->column('note', __('Note'))->editable()->setAttributes(['width' => ' 240px']);
        $grid->sale_id('Nhân viên')->display(function($formalityAreaId) {
            $formalityArea = AuthUser::find($formalityAreaId);
            if($formalityArea){
                return $formalityArea->name;
            }
        })->filter(AuthUser::all()->pluck('name', 'id')->toArray());
        $grid->column('like')->action(StarCustomer::class);

        //$grid->column('like', __('Quan tâm'))->editable('select', Constant::FAVORITE);
        $grid->column('end_date', __('Ngày cuối HĐ'))->filter('range');
        
        $grid->model()->orderBy('like', 'DESC');
        $grid->model()->orderBy('id', 'DESC');
        $grid->exporter(new ExcelExpoter());

        $grid->quickSearch('phone_number', 'name');

        $grid->filter(function($filter){
            //$filter->notIn('sale_id', "Sale")->multipleSelect(AuthUser::all()->pluck('name', 'id')->toArray());
            $filter->where(function ($query) {
                switch ($this->input) {
                    case 'yes':
                        // custom complex query if the 'yes' option is selected
                        $query->whereNotNull('sale_id');
                        break;
                    case 'no':
                        $query->whereNull('sale_id');
                        break;
                }
            }, 'Nhân viên chăm sóc', 'name_for_url_shortcut')->radio([
                '' => 'Tất cả',
                'yes' => 'Đang chăm sóc',
                'no' => 'Chưa chăm sóc',
            ]);
            
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
        $show = new Show(Customer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        //$show->field('birthday', __('Birthday'));
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
        $show->field('end_date', __('Ngày hết hạn'));
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
            //$form->datetime('birthday', __('Birthday'))->default(date('Y-m-d H:i:s'));
            $form->text('room_no', __('Room no'));
            $form->text('phone_number', __('Phone number'));
            $form->select('block_no', __('Toà nhà'))->options(Constant::BLOCK)->setWidth(2, 2);
            $form->select('telco', __('Nhà mạng'))->options(Constant::TELCO)->setWidth(2, 2);
            $form->select('sale_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'))->default(Admin::user()->id);
        //}

        $form->text('setup_at', __('Lịch hẹn gặp'));
        $form->text('plan', __('Gói hiện tại'));
        $form->select('source', __('Nguồn khách'))->options(Constant::SOURCE)->setWidth(2, 2);
        $form->text('note', __('Ghi chú'));
        $form->date('end_date', __('Ngày hết hạn'));
        if (Admin::user()->isRole('Pt') || Admin::user()->isRole('Fm')){
            $form->select('pt_status', __('Trạng thái PT'))->options(Constant::CUSTOMER_STATUS)->setWidth(2, 2);
        } elseif (Admin::user()->isRole('Pt') || Admin::user()->isRole('Fm')){
            $form->select('status', __('Trạng thái'))->options(Constant::CUSTOMER_STATUS)->setWidth(2, 2);
        } else {
            $form->select('status', __('Trạng thái'))->options(Constant::CUSTOMER_STATUS)->setWidth(2, 2);
            $form->select('pt_status', __('Trạng thái PT'))->options(Constant::CUSTOMER_STATUS)->setWidth(2, 2);
        }
        
        $form->select('like', __('Quan tâm'))->options(Constant::FAVORITE)->setWidth(2, 2);
        return $form;
    }
}
