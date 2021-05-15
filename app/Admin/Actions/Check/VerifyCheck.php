<?php

Namespace App\Admin\Actions\Check;

Use App\Models\Check;
Use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;

class VerifyCheck extends RowAction
{
    public function dialog()
    {
        if (Admin::user()->isRole('administrator') ) {
            $this->confirm('Bạn muốn xác nhận check in này?');
        }
    }

    // After the page clicks on the chart in this column, send the request to the backend handle method to execute
    public function handle(Check $check)
    {
        if (Admin::user()->isRole('administrator') ) {
            if ($check->verify != 1){
                $check->verify = 1;
            } else {
                $check->verify = 0;
            }
            $check->save();
        }

        // return a new html to the front end after saving
        $html = $check->verify == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";

        return $this->response()->html($html);
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($like)
    {
        return $like == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";
    }
}