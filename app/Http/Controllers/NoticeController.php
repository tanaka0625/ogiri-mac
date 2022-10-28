<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\Answer_like;
use App\Models\Question_like;
use App\Library\Functions;

class NoticeController extends Controller
{
    public function index(Request $request)
    {

        $id = $request->id;
        $user = User::find($id);


        $answerLikes = Answer_like::where('kind', 0)->where('user_id', '<>', $id)->orderBy('created_at', 'desc')->get();
        $likedAnswers = collect([]);
        for($i=0; $i<$answerLikes->count(); $i++)
        {
            if($answerLikes[$i]->answer->user_id === $id)
            {
                $likedAnswers = $likedAnswers->push($answerLikes[$i]);
            }

            if($likedAnswers->count() > 29)
            {
                break;
            }
        }




        $questionLikes = Question_like::where('kind', 0)->where('user_id', '<>', $id)->orderBy('created_at', 'desc')->get();
        $likedQuestions = collect([]);
        for($i=0; $i<$questionLikes->count(); $i++)
        {
            if($questionLikes[$i]->question->user_id === $id)
            {
                $likedQuestions = $likedQuestions->push($questionLikes[$i]);
            }

            if($likedQuestions->count() > 29)
            {
                break;
            }
        }


        $myQuestions = Question::where('user_id', $id)->get();
        $answers = collect([]);
        for($i=0; $i<$myQuestions->count(); $i++)
        {
            $answers = $answers->concat($myQuestions[$i]->answers);
        }

        $answers = $answers->filter(function ($answer, $key) use ($id) {
            return $answer->user_id != $id;
        });

        $answers = $answers->sortByDesc('created_at')->take(30)->values();


        $ingredients = $likedAnswers->concat($likedQuestions);
        $ingredients = $ingredients->concat($answers);
        $ingredients = $ingredients->sortByDesc('created_at')->take(30)->values();


        $items = array();
        for($i=0; $i<$ingredients->count(); $i++)
        {
            if($ingredients[$i] instanceof Answer)
            {
                $items[$i] = [
                    'key' => $i,
                    'item_type' => "answer",
                    'content' => $ingredients[$i],
                    'question_text' => $ingredients[$i]->getQuestionText(),
                    'question_situation' => Question::find($ingredients[$i]->question_id)->getSituation(),
                    'maker' => $ingredients[$i]->getMaker(),
                ];

            }elseif($ingredients[$i] instanceof Answer_like){

                $items[$i] = [
                    'key' => $i,
                    'item_type' => "answer_like",
                    'content' => $ingredients[$i],
                    'answer_text' => $ingredients[$i]->answer->text,
                    'question_id' => $ingredients[$i]->answer->question_id,
                    'user' => $ingredients[$i]->user,
                ];
 
            }elseif($ingredients[$i] instanceof Question_like){

                $items[$i] = [
                    'key' => $i,
                    'item_type' => "question_like",
                    'content' => $ingredients[$i],
                    'question_text' => $ingredients[$i]->question->text,
                    'user' => $ingredients[$i]->user,
                ];
            }
        }

        $likeUsersList = Functions::likeUsersList($ingredients);


        $data = [

            "items" => $items,
            "likeUsersList" => $likeUsersList,
            "user" => $user

        ];

        return view('Notice.index', $data);

    }
}
