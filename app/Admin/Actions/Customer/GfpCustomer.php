<?php

namespace App\Admin\Actions\Customer;

use Encore\Admin\Actions\RowAction;


class GfpCustomer extends RowAction
{
    protected $id;
    protected $customerId;
    public $name = "Create gfp";
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

//    public function render(Customer $customer)
//    {
//        Admin::script($this->script());
//
//        return '<a href="gfps/create?customer_id ='.$customer->id .'>create gfp</a>';
//
//    }

    public function href()
    {
        $link = "/admin/gfps/create?customer_id=".$this->customerId;
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
