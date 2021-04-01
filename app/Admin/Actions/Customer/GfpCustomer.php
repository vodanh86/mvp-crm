<?php

namespace App\Admin\Actions\Customer;

use App\Models\Gfp;
use Encore\Admin\Actions\RowAction;


class GfpCustomer extends RowAction
{
    protected $id;
    protected $customerId;
    public $name = "Gfp";
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
        $gfpRecord = Gfp::where('customer_id', '=', $this->customerId)->first();
        if($gfpRecord != null){
            $link = "../admin/gfps/{$gfpRecord->id}/edit";
        }else {
            $link = "../admin/gfps/create?customer_id=" . $this->customerId;
        }
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}
