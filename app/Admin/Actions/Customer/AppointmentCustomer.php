<?php


namespace App\Admin\Actions\Customer;


use App\Models\Appointment;

class AppointmentCustomer extends \Encore\Admin\Actions\RowAction
{
    protected $id;
    protected $phoneNumber;
    public $name = "Lịch Hẹn";
    //
    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
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
        $appointmentRecord = Appointment::where('phone_number', '=', $this->phoneNumber)->first();
        if($appointmentRecord){
            $link = "../admin/appointments/{$appointmentRecord->id}/edit";
        }else {
            $link = "../admin/appointments/create?key=" . $this->phoneNumber;
        }
        return $link;
    }

    public function __toString()
    {
        return $this->render();
    }
}