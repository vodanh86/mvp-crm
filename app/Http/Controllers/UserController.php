<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function edit(Request $request, $id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
    
            //$book->name = is_null($request->name) ? $book->name : $book->name;
            //$book->author = is_null($request->author) ? $book->author : $book->author;
            //var_dump($request->all());
            $user->update($request->all());
    
            $result = array("status" => 0, "error" => 0, "data" => $user);
            return response()->json($result, 200);
        } else {
            
            return response()->json([
              "message" => "User not found"
            ], 404);
        }
    }
}
