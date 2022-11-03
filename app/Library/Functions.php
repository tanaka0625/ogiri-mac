<?php
namespace App\Library;

use App\Models\Answer_like;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Question_like;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class Functions
{
    public static function makePageLinks($itemCount, $page)
    {
        if($itemCount === 0){
            $maxPage = 1;
        }else{
            $maxPage = ceil($itemCount/30);
        }

        $pageLinks = array();
        for($i=0; $i<7; $i++){
            if($page-3+$i > 0 && $page-3+$i <= $maxPage){
                $pageLinks[] = $page-3+$i;
            }
        }

        return [
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage
        ];
    }


    public static function likeUsersList($items)
    {
        $likeUsers = array();
        for($i=0; $i<$items->count(); $i++)
        {
            if($items[$i] instanceof Answer)
            {
                $likeUsers[$i]["like"] = $items[$i]->getLikeUsers();
                $likeUsers[$i]["vote"] = $items[$i]->getVoteUsers();

            }elseif($items[$i] instanceof Question){

                $likeUsers[$i]["like"] = $items[$i]->getLikeUsers();

            }else{
                $likeUsers[$i] = 0;
            }
        }

        return $likeUsers;
    }




    public static function judgeWin($items)
    {
        for($i=0; $i<count($items); $i++){

            if($items[$i] instanceof Answer && $items[$i]->isWonAnswer()){
                $items[$i]->wonAnswer = 1;
            }elseif($items[$i] instanceof Answer){
                $items[$i]->wonAnswer = 0;
            }
        }

        return $items;
    
    }

    public static function getPeriods($period)
    {

        for($i=0; date("Ym", strtotime("-" . $i . "month"))>'202109'; $i++){
            if($period === date("Ym", strtotime("-" . $i . "month"))){
                $howLongAgo = $i;
            }
        }

        $previousPeriod = date('Ym', strtotime('-' . $howLongAgo-1 . 'month'));
        $nextPeriod = date('Ym', strtotime('-' . $howLongAgo+1 . 'month'));

        $periods = [
            'previousPeriod' => $previousPeriod,
            'nextPeriod' => $nextPeriod
        ];


        return $periods;
    }

    public static function calculatePoint($userId)
    {
        $answers = Answer::where('user_id', $userId)->get();

        $answerLikePoint = 0;
        for($i=0; $i<$answers->count(); $i++)
        {
            $answerLikePoint = $answerLikePoint + $answers[$i]->answer_likes->where("kind", 0)->count() * 0.5;
        }

        $votePoint = 0;
        for($i=0; $i<$answers->count(); $i++)
        {
            $votePoint = $votePoint + $answers[$i]->answer_likes->where("kind", 1)->count();
        }

        $battleVotePoint = 0;
        for($i=0; $i<$answers->count(); $i++)
        {
            $battleVotePoint = $battleVotePoint + $answers[$i]->answer_likes->where("kind", 2)->count();
        }

        $questions = Question::where('user_id', $userId)->get();

        $questionLikePoint = 0;
        for($i=0; $i<$questions->count(); $i++)
        {
            $questionLikePoint = $questionLikePoint + $questions[$i]->question_likes->count();
        }

        $wonPoint = 0;
        for($i=0; $i<$answers->count(); $i++)
        {
            if($answers[$i]->isWonAnswer())
            {
                $wonPoint = $wonPoint + 3;
            }
        }

        $point = [
            "answerLike" => $answerLikePoint,
            "vote" => $votePoint,
            "questionLike" => $questionLikePoint,
            "battleVote" => $battleVotePoint,
            "won" => $wonPoint,
            "total" => $answerLikePoint + $votePoint + $battleVotePoint + $questionLikePoint + $wonPoint
        ];

        return $point;
    }

    public static function collectionToPaginator($items, $itemsCnt, $perPage, $nowPage, $path, $params)
    {
        $paginator = new LengthAwarePaginator(
            $items,
            $itemsCnt,
            $perPage,
            $nowPage
        );
        $paginator->withPath($path);
        $paginator->appends($params);

        return $paginator;
    }

    public static function makeItems($itemsIngredients)
    {
        $items = array();
        for($i=0; $i<$itemsIngredients->count(); $i++)
        {
            if($itemsIngredients[$i] instanceof Answer)
            {

                $items[$i] = [
                    'key' => $i,
                    'item_type' => "answer",
                    'content' => $itemsIngredients[$i],
                    'question_text' => $itemsIngredients[$i]->getQuestionText(),
                    'question_situation' => Question::find($itemsIngredients[$i]->question_id)->getSituation(),
                    'image_name' => $itemsIngredients[$i]->question->image_name,
                    'maker' => $itemsIngredients[$i]->user->name
                ];

            }elseif($itemsIngredients[$i] instanceof Question)
            {
                $items[$i] = [
                    'key' => $i,
                    'item_type' => "question",
                    'content' => $itemsIngredients[$i],
                    'maker' => $itemsIngredients[$i]->getMaker(),
                    'situation' => $itemsIngredients[$i]->getSituation()
                ];
            }
        }

        return $items;
    }
};

