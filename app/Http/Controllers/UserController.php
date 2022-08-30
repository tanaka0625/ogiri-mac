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
    public function index($id, $category='post',$order='created_at', $page=1)
    {
        $user = User::find($id);

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

        if(Auth::check()){
            $items = Functions::judgeLiked($items, Auth::user()->id);
            $items = Functions::judgeVoted($items, Auth::user()->id);

        }


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


        $items = $items->forPage($page, 30);

        $jsonItems = json_encode(array_values($items->toArray()),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        
        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'category' => $category,
            'order' => $order,
            'user' => $user,
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage,
            'id' => $id,
            'page' => $page
        ];

        return view('User.index', $data);

    }
}
