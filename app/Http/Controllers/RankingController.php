<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RankingController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy("user_point", "desc")->get();


        $data = [
            "users" => $users
        ];


        return view('Ranking.index', $data);


    }


}
