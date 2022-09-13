<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChoiceAvatorController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->id);

        $user->avator = $request->avator;
        $user->save();

        $data = [

        ];

        return response()->json($data);
    }
}
