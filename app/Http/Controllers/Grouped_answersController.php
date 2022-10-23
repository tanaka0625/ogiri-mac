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

        $answers = $entryAnswers->concat($lateAnswers);

        $items = array();
        for($i=0; $i<count($answers); $i++)
        {
            $items[$i] = array();
            $items[$i]['answer'] = $answers[$i];
            $items[$i]['question_text'] = $question->text;
            $items[$i]['question_situation'] = $questionSituation;
            $items[$i]['maker'] = $answers[$i]->getMaker(); 
        }


        if($questionSituation === "voting")
        {
            $btnType = "vote";
        }else{
            $btnType = "like";
        }

        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


        $likeUsers = Functions::likeUsersList($answers);
        $jsonLikeUsers = json_encode($likeUsers,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        $now = date("Y-m-d H:i:s");

        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'question' => $question,
            'questionSituation' => $questionSituation,
            'btnType' => $btnType,
            'questionId' => $question_id,
            'likeUsers' => $likeUsers,
            'jsonLikeUsers' => $jsonLikeUsers
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
