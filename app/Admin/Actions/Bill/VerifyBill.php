<?php

Namespace App\Admin\Actions\Bill;

Use App\Models\Bill;
Use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;

class VerifyBill extends RowAction
{
    public function dialog()
    {
        if (Admin::user()->isRole('administrator') ) {
            $this->confirm('Bạn muốn xác nhận khoản thu chi này này?');
        }
    }

    // After the page clicks on the chart in this column, send the request to the backend handle method to execute
    public function handle(Bill $bill)
    {
        if (Admin::user()->isRole('administrator') ) {
            if ($bill->verify != 1){
                $bill->verify = 1;
            } else {
                $bill->verify = 0;
            }
            $bill->save();
        }

        // return a new html to the front end after saving
        $html = $bill->verify == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";

        return $this->response()->html($html);
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($like)
    {
        return $like == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";
    }
}