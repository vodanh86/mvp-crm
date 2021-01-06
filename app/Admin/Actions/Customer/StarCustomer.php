<?php

Namespace App\Admin\Actions\Customer;

Use App\Models\Customer;
Use Encore\Admin\Actions\RowAction;

class StarCustomer extends RowAction
{
    // After the page clicks on the chart in this column, send the request to the backend handle method to execute
    public function handle(Customer $customer)
    {
        // Switch the value of the `star` field and save
        if ($customer->like != 1){
            $customer->like = 1;
        } else {
            $customer->like = 0;
        }
        $customer->save();

        // return a new html to the front end after saving
        $html = $customer->like == 1 ? "<i class=\"fa fa-star\"></i>" : "<i class=\"fa fa-star-o\"></i>";

        return $this->response()->html($html);
    }

    // This method displays different icons in this column based on the value of the `star` field.
    public function display($like)
    {
        return $like == 1 ? "<i class=\"fa fa-star\"></i>" : "<i class=\"fa fa-star-o\"></i>";
    }
}