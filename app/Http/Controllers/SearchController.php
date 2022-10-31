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

            $answersPlusQuestions = $answers->concat($questions);
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('created_at');

            $itemsIngredients = $answersPlusQuestions->forPage($page, 30)->values();

            $paginator = Functions::collectionToPaginator($itemsIngredients, $answersPlusQuestions->count(), 30, $page, "/search", ["keyWord" => $keyWord]);

            $items = Functions::makeItems($itemsIngredients);

            $likeUsersList = Functions::likeUsersList($itemsIngredients);
    

            $data = [
                'items' => $items,
                'users' => $users,
                'keyWord' => $keyWord,
                'page' => $page,
                'likeUsersList' => $likeUsersList,
                'paginator' => $paginator
            ];
        
        }else{

            $data = [

            ];
        }

        return view('Search.index', $data);
    }
}
