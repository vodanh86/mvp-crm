<?php

namespace App\Admin\Actions\Contract;

use App\Models\Gfp;
use Encore\Admin\Actions\RowAction;


class Checkin extends RowAction
{
    protected $id;
    protected $contractId;
    public $name = "Checkin";
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
        $link = "../admin/checks?contractId=" . $this->contractId;
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
