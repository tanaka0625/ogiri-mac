<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\checkNgWord;


class Answer extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public function scopeWithInPeriod ($query, $period) {
        if($period === 'all') {
            $start = ('2021-10-01 00:00:00');
            $last = date('Y-m-d 23:59:59', strtotime('+1day'));
        }else{
            $year = mb_substr($period, 0, 4);
            $month = mb_substr($period, 4, 2);
    
            $start = date($year . '-' . $month . '-' . '01 00:00:00');
            $last = date($year . '-' . $month . '-' . 't 23:59:59');
    
        }

        return $query->where('created_at', '>=', $start)->where('created_at', '<=', $last);
    }

    public function scopeQuestionIdEquall($query, $question_id)
    {
        return $query->where('question_id', $question_id);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answer_likes()
    {
        return $this->hasMany(Answer_like::class);
    }

    public function getLikeUsers()
    {
        $likeUsers = array();
        for($i=0; $i<count($this->answer_likes); $i++)
        {
            if($this->answer_likes[$i]->kind === 0)
            {
                $likeUsers[] = $this->answer_likes[$i]->user;
            }
        }
        return $likeUsers;
    }


    public function getVoteUsers()
    {
        $voteUsers = array();
        for($i=0; $i<count($this->answer_likes); $i++)
        {
            if($this->answer_likes[$i]->kind != 0)
            {
                $voteUsers[] = $this->answer_likes[$i]->user;
            }
        }
        return $voteUsers;
    }



    public function getQuestionText()
    {
        return $this->question->text;
    }

    public  function getQuestionId()
    {
        return $this->question->id;
    }

    public function getMaker()
    {
        return $this->user->name;
    }

    public function isWonAnswer()
    {
        $question = $this->question;

        $now = date('Y-m-d H:i:s');
        if($now < $question->limit_vote)
        {
            return false;
        }
        $answers = self::where('question_id', $question->id)->get();
        $maxVote = $answers->max('vote');

        if($maxVote < 1)
        {
            return false;
        }

        $maxVoteAnswers = $answers->where('vote', $maxVote);
        $maxVoteAnswers = $maxVoteAnswers->sortBy('created_at')->values();
        $wonAnswer = $maxVoteAnswers[0];

        if($wonAnswer->id === $this->id)
        {
            return true;
        }else{
            return false;
        }

    }


}
