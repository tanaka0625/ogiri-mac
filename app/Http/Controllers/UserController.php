<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Functions;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class UserController extends Controller
{
    public function index($id)
    {

        if(!empty($_GET['category']))
        {
            $category = $_GET['category'];
        }else{
            $category = "post";
        }

        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }else{
            $order = "created_at";
        }

        if(!empty($_GET['page']))
        {
            $page = $_GET['page'];
        }else{
            $page = 1;
        }

        $user = User::find($id);
        $point = Functions::calculatePoint($id);


        if($user->user_point != $point["total"])
        {
            $user->user_point = $point["total"];
            $user->save();
        }

        // 300kg以外のアバター
        for($i=150; $point["total"] % 300 < $i * 2; $i--) {
            $avatorNumber = $i;
        }
 
        if($category === 'post')
        {
            $answers = $user->getAnswers();
            $questions = $user->getQuestions();

        }elseif($category === 'like')
        {
            $answers = $user->getLikedAnswers();
            $questions = $user->getLikedQuestions();
        }

        $items = $answers->merge($questions);

        $makePageLinks = Functions::makePageLinks(count($items), $page);
        $pageLinks = $makePageLinks['pageLinks'];
        $maxPage = $makePageLinks['maxPage'];

        if($order === 'created_at' && $category === 'post')
        {
            $items = $items->sortByDesc('created_at');
        }elseif($order === 'created_at' && $category === 'like')
        {
            $items = $items->sortByDesc('liked_at');
        }elseif($order === 'like')
        {
            $items = $items->sortByDesc('like');
        }

        $items = $items->forPage($page, 30)->values();

        if(Auth::check()){
            $items = Functions::judgeLiked($items, Auth::user()->id);
            $items = Functions::judgeVoted($items, Auth::user()->id);
            $items = Functions::judgeWin($items);
        }

        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        
        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'category' => $category,
            'order' => $order,
            'user' => $user,
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage,
            'id' => $id,
            'page' => $page,
            "point" => $point,
            'avatorNumber' => $avatorNumber
        ];

        return view('User.index', $data);
    }
}
