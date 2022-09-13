<?php
namespace App\Library;

use App\Models\Answer_like;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Question_like;
use App\Models\User;

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

    public static function judgeLiked($items, $userId)
    {
        
        for($i=0; $i<count($items); $i++){


            if($items[$i] instanceof Answer){
                $judgeAleadyLike = Answer_like::where('answer_id', $items[$i]->id)->where('user_id', $userId)->where('kind', 0)->count();
                if($judgeAleadyLike > 0){
                    $items[$i]->myLikeAnswer = 1;
                }else{
                    $items[$i]->myLikeAnswer = 0;
                }
            }else
            {
                $judgeAleadyLike = Question_like::where('question_id', $items[$i]->id)->where('user_id', $userId)->where('kind', 0)->count();
                if($judgeAleadyLike > 0){
                    $items[$i]->myLikeQuestion = 1;
                }else{
                    $items[$i]->myLikeQuestion = 0;
                }
            }
        }

        return $items;
    }



    public static function judgeVoted($items, $userId)
    {
        for($i=0; $i<count($items); $i++){

            if($items[$i] instanceof Answer){
                $judgeVoted = Answer_like::where('answer_id', $items[$i]->id)->where('user_id', $userId)->where('kind', 1)->count();
                if($judgeVoted > 0){
                    $items[$i]->myVoteAnswer = 1;
                }else{
                    $items[$i]->myVoteAnswer = 0;
                }
            }
        }

        return $items;
    }


    public static function judgeBattleVoted($items, $userId)
    {
        for($i=0; $i<count($items); $i++){

            if($items[$i] instanceof Answer){
                $judgeVoted = Answer_like::where('answer_id', $items[$i]->id)->where('user_id', $userId)->where('kind', 2)->count();
                if($judgeVoted > 0){
                    $items[$i]->myVoteAnswer = 1;
                }else{
                    $items[$i]->myVoteAnswer = 0;
                }
            }
        }

        return $items;
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
            $answerLikePoint = $answerLikePoint + $answers[$i]->answer_likes->where("kind", 0)->count() * 0.5
            ;
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
};

