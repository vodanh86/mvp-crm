<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\AdminRoleUsers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $adminRoleUsers = AdminRoleUsers::where("user_id", auth()->user()->id)->first();
        if($adminRoleUsers->role_id == 4 || $adminRoleUsers->role_id == 5){
            $customers = Customer::where("pt_id", auth()->user()->id)->get();
        } else {
            $customers = Customer::where("sale_id", auth()->user()->id)->get();
        }
        $result = array("status" => 0, "data" => $customers);
        return response()->json($result, 200);
    }

    public function detail($id)
    {
        $customer = Customer::find($id);
        $result = array("status" => 0, "data" => $customer);
        return response()->json($result, 200);
    }

    public function edit(Request $request, $id)
    {
        if (Customer::where('id', $id)->exists()) {
            $customer = Customer::find($id);
    
            //$book->name = is_null($request->name) ? $book->name : $book->name;
            //$book->author = is_null($request->author) ? $book->author : $book->author;
            //var_dump($request->all());
            $customer->update($request->all());
    
            $result = array("status" => 0, "error" => 0, "data" => $customer);
            return response()->json($result, 200);
        } else {
            
            return response()->json([
              "message" => "Customer not found"
            ], 404);
        }
    }
}
