<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::all();
        $result = array("status" => 0, "data" => $customers);
        return response()->json($result, 200);
    }
}
