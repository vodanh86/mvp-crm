<?php

namespace App\Admin\Actions\Customer;

use App\Models\Contract;
use Encore\Admin\Actions\RowAction;


class addContract extends RowAction
{
    protected $id;
    protected $customerId;
    public $name = "Thêm hợp đồng";
    //
    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {

    // Your code.
    console.log($(this).data('id'));

});

SCRIPT;
    }

    public function href()
    {
        $link = "../admin/contracts/create?customer_id=" . $this->customerId;
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
