<?php
namespace App\Library;

use App\Models\Answer_like;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Question_like;

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
        for($i=0; $i<13; $i++){
            if($page-6+$i > 0 && $page-6+$i <= $maxPage){
                $pageLinks[] = $page-6+$i;
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

};

