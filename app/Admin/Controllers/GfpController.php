<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Customer\SetupCustomer;
use App\Models\Gfp;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\AuthUser;
use Encore\Admin\Facades\Admin;
use App\Models\Customer;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class GfpController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gfp';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Gfp());

//        $grid->column('id', __('Id'));

        $grid->customer_id('Khách Hàng')->display(function () {
            $customer = Customer::find($this->customer_id)->get();
            return "<a href='customers/" . $this->customer_id . "' style=''>{$customer['name']}</a>";
        })->sortable()->setAttributes(['width' => ' 200px']);

        $grid->column('date_time', __('Thời gian khách hàng đến'));


        $grid->appointment('Hẹn chưa')->display(function ($visited) {
            return $visited;
        })->filter(Constant::YES_NO_QUESTION)->sortable()->editable('select', Constant::YES_NO_QUESTION);

//        $grid->column('visited', __('Visited'));
        $grid->visitted('Đã từng đến chưa')->display(function ($appointment) {
            return $appointment;
        })->filter(Constant::YES_NO_QUESTION)->sortable()->editable('select', Constant::YES_NO_QUESTION);

//        $grid->column('source', __('Source'));
        $grid->source('Biết qua đâu')->display(function ($source) {
            return $source;
        })->filter(Constant::HOW_KNOWN_US)->sortable()->editable('select', Constant::HOW_KNOWN_US);

//        $grid->column('family_support', __('Family support'));
        $grid->family_support('Gia đình đồng ý')->display(function ($familySupport) {
            return $familySupport;
        })->filter(Constant::YES_NO_QUESTION)->sortable()->editable('select', Constant::YES_NO_QUESTION);

        $grid->column('physical_condition', __('Có bệnh không'));
        $grid->target('Mục tiêu')->display(function ($target){
            if (is_array($target)){
                $targetRaw = json_decode($target[0], true);
                $target = [];
                foreach ($targetRaw as $rawValue){
                    $target[] = (int) $rawValue;;
                }
            }
            return $target;
        })->filter(Constant::GFP_TARGET_VALUE)->checkbox(Constant::GFP_TARGET_VALUE);
        $grid->column('how_often', __('Bao buổi 1 tuần'));


        //        $grid->column('sale_id', __('Sale'));
        $grid->sale_id('Nhân viên Sale')->display(function ($formalityAreaId) {
            $sale = AuthUser::find($formalityAreaId);
            if ($sale) {
                return $sale->name;
            }
        })->filter(AuthUser::all()->pluck('name', 'id')->toArray());
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
        $show = new Show(Gfp::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('sale_id', __('Sale id'));
        $show->field('date_time', __('Date time'));
        $show->field('appointment', __('Appointment'));
        $show->field('visited', __('Visited'));
        $show->field('source', __('Source'));
        $show->field('family_support', __('Family support'));
        $show->field('physical_condition', __('Physical condition'));
        $show->field('target', __('Target'));
        $show->field('how_often', __('How often'));
        $show->field('customer_id', __('Customer id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @param null $customerId
     * @return Form
     */
    protected function form($customerId = null): Form
    {
        $form = new Form(new Gfp());

        $form->select('sale_id', __('Nhân viên chăm sóc'))
            ->options(AuthUser::all()->pluck('name', 'id'))->default(Admin::user()->id);
        // $form->number('sale_id', __('Sale id'));
        $form->datetime('date_time', __('Date time'))->default(date('Y-m-d H:i:s'));
        if (is_null($customerId)){
            $form->select('customer_id', __('Tên Học Viên'))->options(Customer::all()->pluck('name', 'id'));
        }else{
            $customer = Customer::all()->firstWhere('id','=',$customerId);
            $form->select('customer_id', __('Tên Học Viên'))->options([$customer['id'] => $customer['name']])->default($customer['id']);
        }
        // $form->number('appointment', __('Appointment'));
        $form->select('appointment', __('Đã có lịch hẹn chưa'))->options(Constant::YES_NO_QUESTION)->setWidth(2, 2);
        $form->select('visited', __('Bạn đã từng đến phòng tập hay chưa'))->options(Constant::YES_NO_QUESTION)->setWidth(2, 2);
        // $form->number('visited', __('Visited'));
        //        $form->number('source', __('Source'));
        $form->select('source', __('Bạn biết phòng tập qua đâu'))->options(Constant::HOW_KNOWN_US);
        //        $form->number('family_support', __('Family support'));
        $form->select('family_support', __('Gia đình có ủng hộ bạn đi tập không'))->options(Constant::YES_NO_QUESTION)->setWidth(2, 2);
        $form->text('physical_condition', __('Bạn có vấn đề gì về sức khoẻ không'));
        $form->checkbox('target', __('Mục tiêu tập luyện của Bạn'))
            ->options(Constant::GFP_TARGET_VALUE);
        $form->number('how_often', __('Bạn có thể đến phòng tập bao buổi 1 tuần'));

        $form->saving(function (Form $form) {
            $form->target = json_encode($form->target);
        });

        return $form;
    }

    public function create(Content $content): Content
    {
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form($customer_id));
    }
}
