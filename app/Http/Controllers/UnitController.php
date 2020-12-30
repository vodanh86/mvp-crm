<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    //
    public function index()
    {
        if (request()->has('q')){
            $unit = Unit::find(request()->q);
            $unit["parent"] = Unit::find($unit->parent_id)->title;
            return $unit;
        }
        return Unit::all()->get(['id', 'name as text']);
    }
}
