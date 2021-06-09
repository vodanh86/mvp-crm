<?php

namespace App\Admin\Actions\Contract;

use Encore\Admin\Actions\RowAction;


class AddBill extends RowAction
{
    protected $id;
    protected $contractId;
    public $name = "Add bill";
    //
    public function __construct($contractId)
    {
        $this->contractId = $contractId;
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
        $link = "../admin/bills/create?contract_id=" . $this->contractId;
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
