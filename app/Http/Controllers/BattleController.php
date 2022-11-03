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
            $question->limit_answer = date('Y-m-d H:i:s', strtotime('+120second'));
            $question->limit_vote = date('Y-m-d H:i:s', strtotime('+150second'));
            $question->save();
        }

        return redirect('/battle');
    }


    public function makeHtml(Request $request)
    {
        $now = date("Y-m-d H:i:s");
        $question = Question::where('kind', 1)->latest()->first();
        $questionMakerName = $question->getMaker();
        $answers = Answer::where("question_id", $question->id)->where("kind", 2)->oldest()->get();
        $answerCount = $answers->count();


        if($question->limit_vote < $now && strtotime($now) <= strtotime($question->limit_vote) + 60  && $answerCount > 2)
        {
            $situation = "watingQuestion";

            $answers = $answers->sortByDesc('battle_vote')->values();

            $winner = $answers[0]->user;
            $likeUsersList = Functions::likeUsersList($answers);

            $data = [
                "items" => Functions::makeItems($answers),
                "likeUsersList" => $likeUsersList,
                "question" => Functions::makeItems(collect([$question])),
                "questionLikeUsers" => Functions::likeUsersList(collect([$question])),
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_question" => strtotime($question->limit_vote) + 60,
                "winner" => $winner
            ];

        }elseif(strtotime($question->limit_vote) < strtotime($now) && $answerCount > 2){

            $situation = "recrutingQuestion";

            $answers = $answers->sortByDesc('battle_vote')->values();
            $likeUsers = Functions::likeUsersList($answers);


            $voteUsersArray = array();
            for($i=0; $i<$answers->count(); $i++)
            {
                $voteUsersArray[] = $answers[$i]->getVoteUsers();
            }

            $data = [
                "items" => Functions::makeItems($answers),
                "likeUsersList" => $likeUsers,
                "question" => Functions::makeItems(collect([$question])),
                "questionLikeUsers" => Functions::likeUsersList(collect([$question])),
                "situation" => $situation,
                "voteUsersArray" => $voteUsersArray
            ];


        }elseif($now < $question->limit_answer)
        {
            $situation = "recrutingAnswer";

            $previousQuestionIngredients = Question::where("id", "<", $question->id)->where("kind", 1)->orderBy("id", "desc")->first();
            $previousItemsIngredients = Answer::where("question_id", $previousQuestionIngredients->id)->where("kind", 2)->orderBy("battle_vote", "desc")->get();
            $previousItemsIngredients->prepend($previousQuestionIngredients);
            $previousItems = Functions::makeItems($previousItemsIngredients);
            $previousLikeUsersList = Functions::likeUsersList($previousItemsIngredients);

            $data = [
                "question" => Functions::makeItems(collect([$question])),
                "questionLikeUsers" => Functions::likeUsersList(collect([$question])),
                "now" => strtotime($now),
                "limit_answer" => strtotime($question->limit_answer),
                "previousItems" => $previousItems,
                "previousLikeUsersList" => $previousLikeUsersList,
                "situation" => $situation
            ];

        }elseif($question->limit_answer <= $now && $now <= $question->limit_vote && $answerCount > 2)
        {
            $situation = "voting";
            $likeUsers = Functions::likeUsersList($answers);

            $data = [
                "items" => Functions::makeItems($answers),
                "likeUsersList" => $likeUsers,
                "question" => Functions::makeItems(collect([$question])),
                "questionLikeUsers" => Functions::likeUsersList(collect([$question])),
                "situation" => $situation,
                "now" => strtotime($now),
                "limit_vote" => strtotime($question->limit_vote)
            ];


        }else{
            $question->limit_answer = date("Y-m-d H:i:s", strtotime("+120second"));
            $question->limit_vote = date("Y-m-d H:i:s", strtotime("+140second"));
            $question->save();

            $situation = "recrutingAnswer";

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
