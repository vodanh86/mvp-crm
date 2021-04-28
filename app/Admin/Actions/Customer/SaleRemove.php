<?php

namespace App\Admin\Actions\Customer;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class SaleRemove extends BatchAction
{
    public $name = 'Bỏ sale quản lý';
    protected $selector = '.report-posts';

    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->sale_id = null;
            $model->save();
        }

        return $this->response()->success('Bỏ sale thành công!')->refresh();
    }

    public function dialog()
    {
        $this->confirm('Bạn có chắc bỏ sale này không?');
    }

    public function html()
    {
        return "<div class='report-posts btn btn-sm btn-warning'><i class='fa fa-info-circle'></i>Bỏ sale quản lý</div>";
    }
}