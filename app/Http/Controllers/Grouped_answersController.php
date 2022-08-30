<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Question;
use App\Rules\checkNgWord;
use App\Http\Requests\AddAnswerRequest;
use App\Library\Functions;




class Grouped_answersController extends Controller
{
    public function index($question_id)
    {
        $entryAnswers = Answer::questionIdEquall($question_id)->where('kind', 1)->get();
        $lateAnswers = Answer::questionIdEquall($question_id)->where('kind', 0)->get();

        $items = $entryAnswers->concat($lateAnswers);


        $question = Question::find($question_id);
        $questionSituation = $question->getSituation($question_id);

        $items = $items->prepend($question);

        if(Auth::check()){
            $items = Functions::judgeLiked($items, Auth::user()->id);
            $items = Functions::judgeVoted($items, Auth::user()->id);
        }

        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'question' => $question,
            'questionSituation' => $questionSituation,
            'questionId' => $question_id
        ];

        return view('Grouped_answers.index', $data);
    }



    public function add(AddAnswerRequest $request, $question_id)
    {

        $Answer = new Answer;
        $Answer->text = $request->text;
        $Answer->user_id = Auth::user()->id;
        $Answer->question_id = $question_id;
        $Answer->kind = $request->kind;
        $Answer->save();

        $Question = Question::find($question_id);
        $answer_number = Answer::where('question_id', $question_id)->count();
        $Question->answer_number = $answer_number;
        $Question->save();

        return redirect('/grouped_answer/' . $question_id);
    }
}
