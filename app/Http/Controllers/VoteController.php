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
        $Answer = Answer::find($answer_id);
        $questionId = $Answer->question_id;
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $judgeVoted = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 1)->count();
        $judgeLiked = Answer_like::where('answer_id', $answer_id)->where('user_id', $user_id)->where('kind', 0)->count();

        $entryAnswers = Answer::where('question_id', $questionId)->where('kind', 1)->get();

        for($i=0; $i<$entryAnswers->count(); $i++)
        {
            if(Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('user_id', $user_id)->where('kind', 1)->count() > 0)
            {
                Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('user_id', $user_id)->where('kind', 1)->delete();

                $entryAnswer = Answer::find($entryAnswers[$i]->id);
                $entryAnswer_vote = Answer_like::where('answer_id', $entryAnswers[$i]->id)->where('kind', 1)->count();
                $entryAnswer->vote = $entryAnswer_vote;
                $entryAnswer->save();

                $maker = User::find($entryAnswer->user_id);
                $maker->user_point = $maker->user_point - 1;
                $maker->save();

                // minus energy
                $user->energy = $user->energy - 200;
                $user->save();

                break;
            }
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

            $maker = User::find($Answer->user_id);
            $maker->user_point = $maker->user_point + 1;
            $maker->save();

            // plus energy
            $user->energy = $user->energy + 200;
            $user->save();

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

                $maker = User::find($Answer->user_id);
                $maker->user_point = $maker->user_point + 1;
                $maker->save();
            }
        }


        $data = [
            'like' => $Answer->like,
            'item' => $Answer,
            'vote' => $Answer->vote,
            'judgeVoted' => $judgeVoted,
            "point" => $maker["user_point"]
        ];

        return response()->json($data);

    }
}
