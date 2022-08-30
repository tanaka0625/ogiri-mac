<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Functions;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\Answer_like;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        $answer_id = $request->id;
        $questionId = $request->questionId;
        $user_id = Auth::user()->id;
        $judgeVoted = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 1)->count();
        $judgeLiked = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 0)->count();
        $Answer = Answer::find($answer_id);

        $entryAnswers = Answer::where('question_id', $questionId)->where('kind', 1)->get();

        for($i=0; $i<$entryAnswers->count(); $i++)
        {
            Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('user_id', $user_id)->where('kind', 1)->delete();
            Answer::find($entryAnswers[$i]->id)->vote = Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('kind', 1)->count();
        }

    
        if($judgeVoted === 0)
        {
            $Answer_like = new Answer_like;
            $Answer_like->answer_id = $answer_id;
            $Answer_like->user_id = $user_id;
            $Answer_like->kind = 1;
            $Answer_like->save();

            $newVoteNumber = Answer_like::where('answer_id', $answer_id)->where('kind', 1)->count();

            $Answer->vote = $newVoteNumber;
            $Answer->save();

            if($judgeLiked === 0)
            {
                $Answer_like = new Answer_like;
                $Answer_like->answer_id = $answer_id;
                $Answer_like->user_id = $user_id;
                $Answer_like->kind = 0;
                $Answer_like->save();
    
                $newLikeNumber = Answer_like::where('answer_id', $answer_id)->where('kind', 0)->count();
    
                $Answer->like = $newLikeNumber;
                $Answer->save();
            }

        }



        $data = [
            'like' => $Answer->like,
            'item' => $Answer,
            'vote' => $Answer->vote,
            'judgeVoted' => $judgeVoted
        ];

        return response()->json($data);

    } 
}
