<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormalityArea;

class FormalityAreaController extends Controller
{
    //
    public function index()
    {
        if (request()->has('q')){
            return FormalityArea::where('formality_level_id', request()->q)
            ->orderBy('order')
            ->get(['id', 'name as text']);
        }
        return FormalityArea::all()->get(['id', 'name as text']);
    }
}
