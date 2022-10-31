<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Rules\checkNgWord;
use App\Http\Requests\AddAnswerRequest;
use App\Library\Functions;




class Grouped_answersController extends Controller
{
    public function index($question_id)
    {

        $question = Question::find($question_id);
        $questionSituation = $question->getSituation($question_id);

        $entryAnswers = Answer::questionIdEquall($question_id)->where('kind', '<>', 0)->get();
        $lateAnswers = Answer::questionIdEquall($question_id)->where('kind', 0)->get();

        $questionList = array();
        $questionList[0] = [
            'key' => 0,
            'item_type' => "question",
            'content' => $question,
            'maker' => $question->getMaker(),
            'situation' => $questionSituation
        ];

        $questionList = Functions::makeItems(collect([$question]));
        $items1 = Functions::makeItems($entryAnswers);
        $items2 = Functions::makeItems($lateAnswers);


        if($questionSituation === "voting")
        {
            $btnType = "vote";
        }else{
            $btnType = "like";
        }


        $likeUsersList1 = Functions::likeUsersList($entryAnswers);
        $likeUsersList2 = Functions::likeUsersList($lateAnswers);
        $questionLikeUserList = Functions::likeUsersList(collect([$question]));

        $now = date("Y-m-d H:i:s");

        $data = [
            'items1' => $items1,
            'items2' => $items2,
            'questionList' => $questionList,
            'question' => $question,
            'questionSituation' => $questionSituation,
            'btnType' => $btnType,
            'questionId' => $question_id,
            'likeUsersList1' => $likeUsersList1,
            'likeUsersList2' => $likeUsersList2,
            'questionLikeUsersList' => $questionLikeUserList,
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

        if($request->kind === "1")
        {
            // minus energy
            $user = User::find(Auth::user()->id);
            $user->energy = $user->energy - 100;
            $user->save();
        }


        return redirect('/grouped_answer/' . $question_id);
    }
}
