<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class settingController extends Controller
{
    public function index(Request $request)
    {

        $id = $request->id;

        $avators = [
            "avator",
            "burger-T-red",
            "pants-red",
            "pants-green",
            "bronze-statue",
            "silver-statue",
            "golden-statue"
        ];




        $data = [
            "id" => $id,
            "avators" => $avators
        ];

        return view("Setting.index", $data);
    }

    public function changeComment(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        $user->comment = $request->comment;
        $user->save();


        return redirect('/setting');
    }
}
