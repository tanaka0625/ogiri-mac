<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Functions;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class searchController extends Controller
{
    public function index()
    {
        if(isset($_GET['keyWord']))
        {
            $keyWord = $_GET['keyWord'];

            if(empty($_GET['page']))
            {
                $page = 1;
            }else{
                $page = $_GET['page'];
            }

            $answers = Answer::where('text', 'like', '%' .$keyWord. '%')->get();
            $questions = Question::where('text', 'like', '%' .$keyWord. '%')->get();
            $users = User::where('name', 'like', '%' .$keyWord. '%')->get();

            $items = $answers->concat($questions);

            if(Auth::check()){
                $items = Functions::judgeLiked($items, Auth::user()->id);
                $items = Functions::judgeVoted($items, Auth::user()->id);
                $items = Functions::judgeWin($items);
            }

            $items = $items->sortByDesc('created_at');

            $makePageLinks = Functions::makePageLinks(count($items), $page);
            $pageLinks = $makePageLinks['pageLinks'];
            $maxPage = $makePageLinks['maxPage'];

            $items = $items->forPage($page, 30);

            $jsonItems = json_encode(array_values($items->toArray()),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

            $data = [
                'items' => $items,
                'users' => $users,
                'keyWord' => $keyWord,
                'jsonItems' => $jsonItems,
                'pageLinks' => $pageLinks,
                'maxPage' => $maxPage,
                'page' => $page

            ];
        
        }else{

            $data = [

            ];
        }

        return view('Search.index', $data);
    }
}
