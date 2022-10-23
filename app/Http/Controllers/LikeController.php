<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Answer_like;
use App\Models\Question_like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{
    public function index(Request $request)
    {
        if($request->itemType === 'answer')
        {
            $answer_id = $request->id;
            $user_id = Auth::user()->id;
            $judgeAleadyLike = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 0)->count();
            $Answer = Answer::find($answer_id);
            $maker = User::find($Answer->user_id);

            $newVoteNumber = Answer_like::where('answer_id', $answer_id)->where('kind', 1)->count();
            $Answer->vote = $newVoteNumber;


            if($judgeAleadyLike === 0)
            {
                $Answer_like = new Answer_like;
                $Answer_like->answer_id = $answer_id;
                $Answer_like->user_id = $user_id;
                $Answer_like->kind = 0;
                $Answer_like->save();

                $maker->user_point = $maker->user_point + 1;
                $maker->save();

            }else
            {
                Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 0)->delete();

                $maker->user_point = $maker->user_point - 1;
                $maker->save();
            }

            $newLikeNumber = Answer_like::where('answer_id', $answer_id)->where('kind', 0)->count();
            $Answer->like = $newLikeNumber;
            $Answer->save();
    
            $data = [
                'item' => $Answer
            ];
    
            return response()->json($data);

        }else
        {
            $question_id = $request->id;
            $user_id = Auth::user()->id;
            $judgeAleadyLike = Question_like::where('question_id', $question_id)->where('user_id', $user_id)->where('kind', 0)->count();
            $Question = Question::find($question_id);
            $maker = User::find($Question->user_id);

            if($judgeAleadyLike === 0)
            {
                $Question_like = new Question_like;
                $Question_like->question_id = $question_id;
                $Question_like->user_id = $user_id;
                $Question_like->kind = 0;
                $Question_like->save();

                $maker->user_point = $maker->user_point + 1;
                $maker->save();

            }else
            {
                Question_like::where('question_id', $question_id)->where('user_id', $user_id)->where('kind', 0)->delete();

                $maker->user_point = $maker->user_point - 1;
                $maker->save();
            }

            $newLikeNumber = Question_like::where('question_id', $question_id)->where('kind', 0)->count();
            $Question->like = $newLikeNumber;
            $Question->save();
    
            $data = [
                'like' => $Question->like,
                'item' => $Question
            ];
    
            return response()->json($data);
        }
    } 
}
