<?php

namespace App\Admin\Actions\Customer;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class SaleAssign extends BatchAction
{
    public $name = 'Chọn sale quản lý';
    protected $selector = '.sale-assign';

    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->sale_id = $request->get("sale_id");
            $model->save();
        }

        return $this->response()->success('Chọn sale thành công!')->refresh();
    }

    public function form()
    {
        $this->select('sale_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'));
    }

}