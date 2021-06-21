<?php

namespace App\Admin\Actions\Customer;

use App\Models\Contract;
use Encore\Admin\Actions\RowAction;


class viewContract extends RowAction
{
    protected $id;
    protected $customerId;
    public $name = "Xem hợp đồng";
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
        $contractRecord = Contract::where('customer_id', '=', $this->customerId)->first();
        $link = "../admin/contracts?customer_id=" . $this->customerId;
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
