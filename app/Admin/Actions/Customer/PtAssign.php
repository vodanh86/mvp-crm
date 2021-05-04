<?php

namespace App\Admin\Actions\Customer;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class PtAssign extends BatchAction
{
    public $name = 'Chọn pt quản lý';
    protected $selector = '.report-posts';

    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->pt_id = $request->get("pt_id");
            $model->save();
        }

        return $this->response()->success('Report submitted!')->refresh();
    }

    public function form()
    {
        $this->select('pt_id', __('Nhân viên chăm sóc'))->options(AuthUser::all()->pluck('name','id'));
    }
    
}