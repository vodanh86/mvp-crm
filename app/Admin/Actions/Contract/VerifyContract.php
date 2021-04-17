<?php

Namespace App\Admin\Actions\Contract;

Use App\Models\Contract;
Use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;

class VerifyContract extends RowAction
{
    public function dialog()
    {
        if (Admin::user()->isRole('administrator') ) {
            $this->confirm('Bạn muốn xác nhận hợp đồng này?');
        }
    }

    // After the page clicks on the chart in this column, send the request to the backend handle method to execute
    public function handle(Contract $contract)
    {
        if (Admin::user()->isRole('administrator') ) {
            if ($contract->verify != 1){
                $contract->verify = 1;
            } else {
                $contract->verify = 0;
            }
            $contract->save();
        }

        // return a new html to the front end after saving
        $html = $contract->verify == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";

        return $this->response()->html($html);
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($like)
    {
        return $like == 1 ? "<i class=\"fa fa-check text-warning\"></i>" : "<i class=\"fa fa-times\"></i>";
    }
}