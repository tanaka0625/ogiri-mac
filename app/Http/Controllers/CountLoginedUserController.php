<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CountLoginedUserController extends Controller
{
    public function index()
    {
        $now = date('Y-m-d H:i:s');
        $range = date('Y-m-d H:i:s', strtotime('-10min'));
        $loginedUserCnt = User::where('last_login', ">", $range)->count();

        $data = [
            "loginedUserCnt" => $loginedUserCnt
        ];

        return response()->json($data);
    }
}
