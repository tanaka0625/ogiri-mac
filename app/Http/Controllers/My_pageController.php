<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Functions;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class My_pageController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);


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
            $order = "like";
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

        $answersPlusQuestions = $answers->merge($questions);


        $makePageLinks = Functions::makePageLinks(count($answersPlusQuestions), $page);
        $pageLinks = $makePageLinks['pageLinks'];
        $maxPage = $makePageLinks['maxPage'];

        if($order === 'created_at' && $category === 'post')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('created_at');
        }elseif($order === 'created_at' && $category === 'like')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('liked_at');
        }elseif($order === 'like')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('like');
        }


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
            'category' => $category,
            'order' => $order,
            'user' => $user,
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage,
            'id' => $id,
            'page' => $page,
            "point" => $point,
            "avatorNumber" => $avatorNumber,
            'likeUsersList' => $likeUsersList,
            "jsonLikeUsersList" => $jsonLikeUsersList
            ];

        return view('My_page.index', $data);

    }
}
