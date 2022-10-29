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


            $items = array();
            for($i=0; $i<$itemsIngredients->count(); $i++)
            {
                if($itemsIngredients[$i] instanceof Answer)
                {
    
                    $items[$i] = [
                        'key' => $i,
                        'item_type' => "answer",
                        'content' => $itemsIngredients[$i],
                        'question_text' => $itemsIngredients[$i]->getQuestionText(),
                        'question_situation' => Question::find($itemsIngredients[$i]->question_id)->getSituation(),
                        'maker' => $itemsIngredients[$i]->user->name
                    ];
    
                }elseif($itemsIngredients[$i] instanceof Question)
                {
                    $items[$i] = [
                        'key' => $i,
                        'item_type' => "question",
                        'content' => $itemsIngredients[$i],
                        'maker' => $itemsIngredients[$i]->getMaker(),
                        'situation' => $itemsIngredients[$i]->getSituation()
                    ];
                }
            }


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
