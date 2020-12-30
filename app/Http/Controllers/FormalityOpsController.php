<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormalityOps;

class FormalityOpsController extends Controller
{
    //
    public function index()
    {
        if (request()->has('q')){
            return FormalityOps::where('formality_level_id', request()->q)
            ->orderBy('order')
            ->get(['id', 'name as text']);
        }
        return FormalityOps::all()->get(['id', 'name as text']);
    }
}
