<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Library\Functions;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddAnswerRequest;


class BattleController extends Controller
{
    public function index(Request $request)
    {

        $data = [

        ];

        return view('Battle.index', $data);
    }

    public function addAnswer(AddAnswerRequest $request)
    {
        $question = Question::where('kind', "1")->latest()->first();

        $Answer = new Answer;
        $Answer->text = $request->text;
        $Answer->user_id = Auth::user()->id;
        $Answer->question_id = $question->id;
        $Answer->kind = 2;
        $Answer->save();

        $answerCount = Answer::where("question_id", $question->id)->count();
        $question->answer_number = $answerCount;
        $question->save();

        return redirect('/battle');
    }

    public function addQuestion(AddAnswerRequest $request)
    {

        $now = date("Y-m-d H:i:s");
        $previousQuestion = Question::where('kind', "1")->latest()->first();

        if($previousQuestion->limit_vote < $now)
        {
            $question = new Question;
            $question->text = $request->text;
            $question->user_id = Auth::user()->id;
            $question->kind = 1;
            $question->limit_answer = date('Y-m-d H:i:s', strtotime('+60second'));
            $question->limit_vote = date('Y-m-d H:i:s', strtotime('+80second'));
            $question->save();
        }

        return redirect('/battle');
    }


    public function makeHtml(Request $request)
    {
        $now = date("Y-m-d H:i:s");
        $question = Question::where('kind', "1")->latest()->first();
        $questionMakerName = $question->getMaker();
        $answers = Answer::where("question_id", $question->id)->where("kind", 2)->oldest()->get();
        $answerCount = $answers->count();

        for($i=0; $i<$answers->count(); $i++)
        {
            $answers[$i]->makerName = $answers[$i]->getMaker();
        }

        if($question->limit_vote <= $now && strtotime($now) < strtotime($question->limit_vote) + 60  && $answerCount > 2)
        {
            $situation = "watingQuestion";
            $x =1;

            if(Auth::check())
            {
                $answers = Functions::judgeBattleVoted($answers, Auth::user()->id);
            }
            $answers = $answers->sortByDesc('battle_vote')->values();

            $data = [
                "answers" => $answers,
                "question" => $question,
                "questionMakerName" => $questionMakerName,
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_question" => strtotime($question->limit_vote) + 60
            ];

        }elseif($question->limit_vote <= $now && $answerCount > 2){

            $situation = "recrutingQuestion";
            $x = 5;

            if(Auth::check())
            {
                $answers = Functions::judgeBattleVoted($answers, Auth::user()->id);
            }
            $answers = $answers->sortByDesc('battle_vote')->values();

            $data = [
                "answers" => $answers,
                "question" => $question,
                "questionMakerName" => $questionMakerName,
                "situation" => $situation
            ];


        }elseif($now < $question->limit_answer)
        {
            $situation = "recrutingAnswer";
            $x = 2;

            $data = [
                "question" => $question,
                "questionMakerName" => $questionMakerName,
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_answer" => strtotime($question->limit_answer)
            ];

        }elseif($question->limit_answer <= $now && $now <= $question->limit_vote && $answerCount > 2)
        {
            $situation = "voting";
            $x = 3;

            if(Auth::check())
            {
                $answers = Functions::judgeBattleVoted($answers, Auth::user()->id);
            }

            $data = [
                "answers" => $answers,
                "question" => $question,
                "questionMakerName" => $questionMakerName,
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_vote" => strtotime($question->limit_vote)
            ];


        }else{
            $question->limit_answer = date("Y-m-d H:i:s", strtotime("+60second"));
            $question->limit_vote = date("Y-m-d H:i:s", strtotime("+80second"));
            $question->save();

            $situation = "recrutingAnswer";
            $x = 4;

            $data = [
                "question" => $question,
                "questionMakerName" => $questionMakerName,
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_answer" => strtotime($question->limit_answer)
            ];
        }

        return response()->json($data);
    }
}
