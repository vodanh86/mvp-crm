<?php

namespace App\Admin\Controllers;

use DB;
use App\Models\Contract;
use App\Models\AuthUser;
use App\Models\Customer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Admin\Actions\Contract\VerifyContract;
use App\Admin\Actions\Contract\Checkin;
use App\Admin\Actions\Contract\AddBill;

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
        $customerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
        $listPts = AuthUser::pluck('name', 'id');
        $grid = new Grid(new Contract());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'))->filter("like");
        $grid->column('code', __('Mã'))->filter("like");
        $grid->contract_type('Loại')->using(Constant::CONTRACT_TYPE)->filter(Constant::CONTRACT_TYPE);
        $grid->type('Khách')->using(Constant::PT_CONTRACT_TYPE)->filter(Constant::PT_CONTRACT_TYPE);
        $grid->customer('Tên khách')->display(function($customer){
            if ($customer){
                return "<span class='label label-success'><a href='customers/".$customer['id']."' style='color:white'>{$customer['name']}</a></span>";
            }
        })->sortable();
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title);
        });
        $grid->bills('Thanh toán')->display(function ($bills) {

            $bills = array_map(function ($bill) {
                return "<span class='label label-success'><a href='bills/".$bill['id']."' style='color:white'>{$bill['code']}</a></span>";
            }, $bills);
        
            return join('&nbsp;', $bills);
        });
        $grid->column('days', __('Days'));
        $grid->column('used_days', __('Số ngày đã tập'));
        $grid->column('price_one', __('Giá 1 session'))->display(function ($title) {
            return number_format($title);
        })->sortable();
        $grid->column('sale_id', __('Người bán'))->display(function ($pts) use($listPts) {
            $newDes = array();
            foreach($pts as $pt ){
                $newDes[] = $listPts[$pt];
            }
            return implode(",", $newDes);
        });
        $grid->column('verify', __('Xác nhận'))->action(VerifyContract::class)->filter(Constant::YES_NO_QUESTION);
        $grid->column('conditional_note', __('Điều kiện phụ'))->display(function ($title) {
            if ($title) {
                if (strlen($title) > 10) {
                    return explode(' ', $title)[0]. "..."; 
                } else {
                    return $title;
                }
            }
        })->sortable()->modal('Điều kiện phụ', function ($model) {
            return $model->conditional_note;
        });
        $grid->column('cared_note', __('Lưu ý'))->display(function ($title) {
            if ($title) {
                if (strlen($title) > 10) {
                    return explode(' ', $title)[0]. "..."; 
                } else {
                    return $title;
                }
            }
        })->sortable()->modal('Lưu ý', function ($model) {
            return $model->cared_note;
        });
        
        $grid->column('bought_date', __('Ngày mua'))->sortable();
        $grid->column('expired_at', __('Ngày hết hạn'))->sortable();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if($actions->row->verify == 1){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->add(new Checkin($actions->row->id));
            } else {
                $actions->add(new AddBill($actions->row->id));
            }
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });
        $grid->disableCreateButton();
        if ($customerId != null){
            $grid->model()->where('customer_id', '=', $customerId);
        } 
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
        $show = new Show(Contract::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('days', __('Days'));
        $show->field('conditional_note', __('Điều kiện phụ'));
        $show->field('cared_note', __('Điều cần lưu ý'));
        $show->field('cared_note', __('Điều cần lưu ý'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
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
    protected function form($customerId = null)
    {
        $form = new Form(new Contract());

        $form->text('name', __('Name'))->required();
        $form->select('customer_id')->options(
        Customer::all(DB::raw('CONCAT(name, " - ", phone_number) AS full_name, id'))
        ->pluck('full_name', 'id')
        )->default($customerId);
        $form->text('code', __('Mã'))->required();
        $form->date('bought_date', 'Ngày mua')->required();
        $form->date('expired_at', 'Ngày hết hạn');
        $form->multipleSelect('sale_id')->options(AuthUser::all()->pluck('name', 'id'));
        $form->currency('price', __('Price'))->symbol('VND');
        $form->select('contract_type', __('Loại hợp đồng'))->options(Constant::CONTRACT_TYPE)->default(1)->setWidth(2, 2)
        ->when(0, function (Form $form) {
            $form->select('type', __('Khách'))->options(Constant::PT_CONTRACT_TYPE)->default(1)->setWidth(2, 2);
            $form->select('pt_category', __('Loại hợp đồng PT'))->options(Constant::PT_CATEGORY)->default(1)->setWidth(2, 2);
            $form->text('days', __('Days'));
            $form->text('used_days', __('Số ngày đã tập'));
            $form->currency('price_one', __('Giá 1 session'))->symbol('VND')->readonly();
        })
        ->when(1, function (Form $form) {
            $form->select('time', __('Thời điểm tập'))->options(Constant::CONTRACT_TIME)->default(0)->setWidth(2, 2);
            $form->select('length', __('Thời gian tập'))->options(Constant::CONTRACT_LENGTH)->default(0)->setWidth(2, 2);
            $form->select('service', __('Gói tập'))->options(Constant::CONTRACT_SERVICE)->default(0)->setWidth(2, 2);
            $form->select('place', __('Phòng tập'))->options(Constant::CONTRACT_PLACE)->default(0)->setWidth(2, 2);
            $form->number('member', __('Số thành viên'))->default(1);
        })
        ->when(5, function (Form $form) {
            $form->select('type', __('Loại hợp đồng PT'))->options(Constant::PT_CONTRACT_TYPE)->default(1)->setWidth(2, 2);
            $form->text('days', __('Days'));
            $form->currency('price_one', __('Giá 1 session'))->symbol('VND')->readonly();
        });
        $form->text('conditional_note', __('Điều kiện phụ'));
        $form->text('cared_note', __('Điều cần lưu ý'));
        $form->select('verify', __('Xác nhận'))->options(Constant::YES_NO_QUESTION)->default(0)->setWidth(2, 2);

       if (Admin::user()->isAdministrator()) {
            $form->hasMany('bills', function (Form\NestedForm $form) {
                $form->text('code', 'Mã biên nhận');
                $form->currency('price', 'Số tiền');
                $form->datetime('bought_date', 'Ngày thanh toán');
                $form->select('verify', __('Xác nhận'))->options(Constant::YES_NO_QUESTION)->default(0)->setWidth(2, 2);
            });
        }
        // callback before save
        $form->saving(function (Form $form) {
            if (($form->contract_type == 0) || ($form->contract_type == 5)){
                if ($form->type == 1 && $form->days != 0){
                    $form->price_one = $form->price/$form->days;
                }
                if ($form->type == 0){
                    $form->price_one = 80000;
                }
            }
        });
        return $form;
    }

    public function create(Content $content): Content
    {
        $customerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form($customerId));
    }
}
