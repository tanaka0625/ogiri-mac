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



        $items = $likedAnswers->concat($likedQuestions);
        $items = $items->concat($answers);
        $items = $items->sortByDesc('created_at')->take(30)->values();
        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


        $likeUsers = Functions::likeUsersList($items);
        $jsonLikeUsers = json_encode($likeUsers,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


        $data = [

            "items" => $items,
            "jsonItems" => $jsonItems,
            "likeUsers" => $likeUsers,
            "jsonLikeUsers" => $jsonLikeUsers

        ];

        return view('Notice.index', $data);

    }
}
