<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $data = [

        ];

        return view('Rule.index', $data);
    }
}
