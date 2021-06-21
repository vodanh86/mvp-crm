<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Customer\GfpCustomer;
use App\Models\Appointment;
use App\Models\AuthUser;
use App\Models\Customer;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Actions\Customer\VerifyCustomer;
use App\Admin\Actions\Customer\ShowCustomer;
use App\Admin\Actions\Customer\SetupCustomer;

class AppointmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Appointment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Appointment());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->filter('like')->sortable()->editable();
        $grid->column('phone_number', __('Phone number'))->filter('like')->editable();
        $grid->column('app_date', __('App date'))->sortable()->filter('date')->editable();
        $grid->column('app_time', __('App time'))->editable();
        $grid->column('place', __('Địa chỉ'))->editable()->using(Constant::CONTRACT_PLACE);
        $grid->column('note', __('Note'))->editable();
        $grid->sale_id('Nhân viên Sale')->display(function($saleId) {
            $sale = AuthUser::find($saleId);
            if($sale){
                return $sale->name;
            }
        })->filter(AuthUser::all()->pluck('name', 'id')->toArray());
        $grid->type('Loại')->display(function($type) {
            if (isset($type)){
                return Constant::APP_TYPE[$type];
            }
        })->filter(Constant::BLOCK)->sortable();
        $grid->column('verify', __('Xác nhận'))->action(VerifyCustomer::class);
        $grid->column('show', __('Show'))->action(ShowCustomer::class);
        $grid->column('setup', __('Setup'))->action(SetupCustomer::class);
        $grid->column('done', __('Done'))->editable();

        if (!(Admin::user()->isRole('Sm') || Admin::user()->isRole('administrator'))) {
            $grid->model()->where('sale_id', '=', Admin::user()->id);
        }
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $customer = Customer::where('phone_number','=',$actions->row->phone_number)->first();
            if($customer){
                $actions->add(new GfpCustomer($customer->id));
            }
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
        $show = new Show(Appointment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('phone_number', __('Phone number'));
        $show->field('app_date', __('App date'));
        $show->field('sale_id', __('Sale id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('show', __('Show'));
        $show->field('setup', __('Setup'));
        $show->field('done', __('Done'));
        $show->field('app_time', __('App time'));
        $show->field('note', __('Note'));

        return $show;
    }

    /**
     * Make a form builder.
     * @param null $phoneNumber
     * @return Form
     */
    protected function form($phoneNumber=null)
    {
        $form = new Form(new Appointment());

        if (is_null($phoneNumber)){
            $form->text('name', __('Name'));
            $form->text('phone_number', __('Phone number'));
        }else{
            $customer = Customer::all()->firstWhere('phone_number','=',$phoneNumber);
            $form->text('name', __('Name'))->default($customer['name']);
            $form->text('phone_number', __('Phone number'))->default($phoneNumber);
        }
        $form->date('app_date', __('App date'))->default(date('Y-m-d'));
        $form->text('app_time', __('App time'));
        $form->select('place', __('Địa điểm'))->options(Constant::CONTRACT_PLACE)->setWidth(2, 2);
        $form->text('note', __('Note'));
        $form->select('type', __('Loại hẹn'))->options(Constant::APP_TYPE)->setWidth(2, 2);
        $form->select('sale_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'))->default(Admin::user()->id);
        $form->text('done', __('Done'));
        return $form;
    }

    public function create(Content $content): Content
    {
        $phoneNumber = isset($_GET['key']) ? $_GET['key'] : null;
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form($phoneNumber));
    }

}
