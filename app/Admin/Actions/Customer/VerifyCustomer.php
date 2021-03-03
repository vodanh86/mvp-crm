<?php

Namespace App\Admin\Actions\Customer;

Use App\Models\Appointment;
Use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;

class VerifyCustomer extends RowAction
{
    // After the page clicks on the chart in this column, send the request to the backend handle method to execute
    public function dialog()
    {
        if (Admin::user()->isRole('Sm') || Admin::user()->isRole('administrator') ) {
            $this->confirm('Bạn muốn xác nhận lịch hẹn này?');
        }
    }

    public function handle(Appointment $appointment)
    {
        if (Admin::user()->isRole('Sm') || Admin::user()->isRole('administrator') ) {
            if ($appointment->verify != 1){
                $appointment->verify = 1;
            } else {
                $appointment->verify = 0;
            }
            $appointment->save();
        }

        // return a new html to the front end after saving
        $html = $appointment->verify == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";

        return $this->response()->html($html);
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($like)
    {
        return $like == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";
    }
}