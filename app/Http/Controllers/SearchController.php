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

            $makePageLinks = Functions::makePageLinks(count($answersPlusQuestions), $page);
            $pageLinks = $makePageLinks['pageLinks'];
            $maxPage = $makePageLinks['maxPage'];

            $answersPlusQuestions = $answersPlusQuestions->forPage($page, 30)->values();

            $items = array();
            for($i=0; $i<$answersPlusQuestions->count(); $i++)
            {
                if($answersPlusQuestions[$i] instanceof Answer)
                {
                    $items[$i]['answer'] = $answersPlusQuestions[$i];
                    $items[$i]['question_text'] = $answersPlusQuestions[$i]->getQuestionText();
                    $items[$i]['question_situation'] = Question::find($answersPlusQuestions[$i]->question_id)->getSituation();
                    $items[$i]['maker'] = $answersPlusQuestions[$i]->getMaker();
                    $items[$i]["key"] = $i;
                }elseif($answersPlusQuestions[$i] instanceof Question)
                {
                    $items[$i]['question'] = $answersPlusQuestions[$i];
                    $items[$i]['maker'] = $answersPlusQuestions[$i]->getMaker();
                    $items[$i]['situation'] = $answersPlusQuestions[$i]->getSituation();
                    $items[$i]["key"] = $i;
                }
            }

            $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

            $likeUsersList = Functions::likeUsersList($answersPlusQuestions);
            $jsonLikeUsersList = json_encode($likeUsersList,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    

            $data = [
                'items' => $items,
                'jsonItems' => $jsonItems,
                'users' => $users,
                'keyWord' => $keyWord,
                'jsonItems' => $jsonItems,
                'pageLinks' => $pageLinks,
                'maxPage' => $maxPage,
                'page' => $page,
                'likeUsersList' => $likeUsersList,
                'jsonLikeUsersList' => $jsonLikeUsersList

            ];
        
        }else{

            $data = [

            ];
        }

        return view('Search.index', $data);
    }
}
