<?php

namespace App\Admin\Controllers;

use App\Models\Bill;
use App\Models\Contract;
use App\Models\AuthUser;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Bill\VerifyBill;

class BillController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Quản lý thanh toán';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $listPts = AuthUser::pluck('name', 'id');
        $grid = new Grid(new Bill());

        $grid->column('id', __('Id'));
        $grid->column('code', __('Code'))->filter("like")->width(60);
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title);
        });
        $grid->column('verify', __('Xác nhận'))->action(VerifyBill::class)->filter(Constant::YES_NO_QUESTION);
        $grid->column('note', __('Note'))->display(function ($title) {
            if ($title) {
                if (strlen($title) > 10) {
                    return explode(' ', $title)[0]. "..."; 
                } else {
                    return $title;
                }
            }
        })->sortable()->modal('Note', function ($model) {
            return $model->conditional_note;
        });
        
        $grid->column('bought_date', __('Ngày mua'))->sortable();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if($actions->row->verify == 1){
                $actions->disableDelete();
                $actions->disableEdit();
            }
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });
        $grid->quickSearch('code');
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
        $show = new Show(Bill::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('code', __('Code'));
        $show->field('price', __('Price'));
        $show->field('bought_date', __('Ngày thanh toán'));
        $show->field('contract_id', __('Họp đồng'));
        $show->field('note', __('Điều cần lưu ý'));
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
    protected function form($contractId = null)
    {
        $form = new Form(new Bill());
        $form->text('code', __('Code'))->required();
        $form->date('bought_date', 'Ngày đóng tiền')->required();
        $form->select('payment_type', __('Loại thanh toán'))->options(Constant::PAYMENT_TYPE)->default(0)->setWidth(2, 2);
        $form->currency('price', __('Price'))->symbol('VND');
        $form->text('contract_id')->default($contractId)->readonly();
        $form->text('note', __('Note'));
        return $form;
    }

    public function create(Content $content): Content
    {
        $contractId = isset($_GET['contract_id']) ? $_GET['contract_id'] : null;
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form($contractId));
    }
}
