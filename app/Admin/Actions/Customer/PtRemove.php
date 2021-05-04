<?php

namespace App\Admin\Actions\Customer;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class PtRemove extends BatchAction
{
    public $name = 'Bỏ pt quản lý';
    protected $selector = '.pt-remove';

    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->pt_id = null;
            $model->save();
        }

        return $this->response()->success('Bỏ pt thành công!')->refresh();
    }

    public function dialog()
    {
        $this->confirm('Bạn có chắc bỏ pt này không?');
    }

}