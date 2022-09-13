<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Answer_like;
use App\Models\Question_like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DeleteController extends Controller
{
    public function index(Request $request)
    {
        if($request->itemType === 'answer')
        {
            $id = $request->id;
            $user_id = Auth::user()->id;
            $Answer = Answer::find($id);
            $question_id = $Answer->question_id;
            $Question = Question::find($question_id);

            Answer::where('id', $id)->delete();

            Answer_like::where('answer_id', $id)->delete();

            $answer_number = Answer::where('question_id', $question_id)->count();
            $Question->answer_number = $answer_number;
            $Question->save();
    
            $data = [
                'item' => $Answer
            ];
    
            return response()->json($data);
        }
    } 
}
