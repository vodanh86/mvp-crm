<?php

namespace App\Admin\Selectable;

use App\Models\Contract;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Grid\Selectable;

class SelectContract extends Selectable
{
    public $model = Contract::class;

    public function make()
    {
        $this->column('id');
        $this->column('code');
        $this->column('name');
        $this->column('price');
        $this->column('days');

        $this->filter(function (Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('code');
        });
    }
}