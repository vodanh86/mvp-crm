<?php

namespace App\Admin\Controllers;

use App\Models\Contract;
use App\Models\AuthUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Contract\VerifyContract;
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
        $listPts = AuthUser::pluck('name', 'id');
        $grid = new Grid(new Contract());

        $grid->column('id', __('Id'));
        $grid->column('code', __('Code'))->filter("like")->width(60);
        $grid->column('name', __('Name'));
        $grid->contract_type('Loại')->using(Constant::CONTRACT_TYPE)->filter(Constant::CONTRACT_TYPE);
        $grid->type('Loại PT')->using(Constant::PT_CONTRACT_TYPE)->filter(Constant::PT_CONTRACT_TYPE);
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title);
        });
        $grid->column('days', __('Days'));
        $grid->column('price_one', __('Giá 1 session'))->display(function ($title) {
            return number_format($title);
        })->sortable();
        $grid->column('sale_id', __('Người bán'))->display(function ($pts) use($listPts) {
            $newDes = array();
            foreach($pts as $pt ){
                $newDes[] = $listPts[$pt];
            }
            return json_encode($newDes);
        });
        $grid->column('verify', __('Xác nhận'))->action(VerifyContract::class)->filter(Constant::YES_NO_QUESTION);
        $grid->column('conditional_note', __('Điều kiện phụ'))->display(function ($title) {
            if ($title) {
                if (strlen($title) > 10) {return substr($title, 0, 10). "..."; } else {
                    return $title;
                }
            }
        })->sortable();
        $grid->column('cared_note', __('Lưu ý'))->display(function ($title) {
            if ($title) {
                if (strlen($title) > 10) {return substr($title, 0, 10). "..."; } else {
                    return $title;
                }
            }
        })->sortable();
        
        $grid->column('bought_at', __('Ngày mua'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if($actions->row->verify == 1){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->add(new Checkin($actions->row->id));
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
        $show = new Show(Contract::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('code', __('Code'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('days', __('Days'));
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
        $form = new Form(new Contract());

        $form->text('code', __('Code'));
        $form->text('name', __('Name'));
        $form->date('bought_date', 'Ngày mua');
        $form->multipleSelect('sale_id')->options(AuthUser::all()->pluck('name', 'id'));
        $form->select('contract_type', __('Loại hợp đồng'))->options(Constant::CONTRACT_TYPE)->default(1)->setWidth(2, 2)
        ->when(0, function (Form $form) {
            $form->select('type', __('Loại hợp đồng PT'))->options(Constant::PT_CONTRACT_TYPE)->default(1)->setWidth(2, 2);
            $form->currency('price', __('Price'))->symbol('VND');
            $form->text('days', __('Days'));
            $form->currency('price_one', __('Giá 1 session'))->symbol('VND')->readonly();
        })
        ->when(1, function (Form $form) {
            $form->currency('price', __('Price'))->symbol('VND');
        })
        ->when(2, function (Form $form) {
            $form->currency('price', __('Price'))->symbol('VND');
        })
        ->when(3, function (Form $form) {
            $form->currency('price', __('Price'))->symbol('VND');
        });
        $form->text('conditional_note', __('Điều kiện phụ'));
        $form->text('cared_note', __('Điều cần lưu ý'));
        // callback before save
        $form->saving(function (Form $form) {
            if ($form->type == 1 && $form->days != 0){
                $form->price_one = $form->price/$form->days;
            }
            if ($form->type == 0){
                $form->price_one = 80000;
            }
        });
        return $form;
    }
}
