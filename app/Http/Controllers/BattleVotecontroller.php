<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer_like;
use App\Library\Functions;
use Illuminate\Support\Facades\Auth;


class BattleVotecontroller extends Controller
{
    public function index(Request $request)
    {
        $answer_id = $request->id;
        $questionId = $request->questionId;
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $Answer = Answer::find($answer_id);

        $entryAnswers = Answer::where('question_id', $questionId)->where('kind', 2)->get();

        for($i=0; $i<$entryAnswers->count(); $i++)
        {
            $entryAnswer = $entryAnswers[$i];
            $likeCount = Answer_like::where('answer_id', $entryAnswer->id)->where('user_id', $user_id)->where('kind', 2)->count();

            if($likeCount > 0)
            {
                Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('user_id', $user_id)->where('kind', 2)->delete();

                $entryAnswer_vote = Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('kind', 2)->count();
                $entryAnswer->battle_vote = $entryAnswer_vote;
                $entryAnswer->save();

                $user->user_point = $user->user_point - 1;
                $user->save();

                break;
            }
        }

        $judgeVoted = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 2)->count();

        if($judgeVoted === 0)
        {
            $Answer_like = new Answer_like;
            $Answer_like->answer_id = $answer_id;
            $Answer_like->user_id = $user_id;
            $Answer_like->kind = 2;
            $Answer_like->save();

            $newVoteNumber = Answer_like::where('answer_id', $answer_id)->where('kind', 2)->count();

            $Answer->battle_vote = $newVoteNumber;
            $Answer->save();

            $user->user_point = $user->user_point + 1;
            $user->save();
        }


        $judgeLiked = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 0)->count();

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

            $user->user_point = $user->user_point + 1;
            $user->save();
        }


        $data = [
            'item' => $Answer,
            'vote' => $Answer->battleVote,
            'judgeVoted' => $judgeVoted
        ];

        return response()->json($data);

    }
}
