<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    //
    public function index()
    {
        $plans = Plan::all();
        $result = array("status" => 0, "data" => $plans);
        return response()->json($result, 200);
    }
}
