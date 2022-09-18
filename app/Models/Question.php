<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = array('id');


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question_likes()
    {
        return $this->hasMany(Question_like::class);
    }

    public function scopeRecruting($query)
    {
        return $query->where('limit_answer', '>', date("Y-m-d H:i:s"))->where("kind", 0);
    }

    public function scopeVoting($query)
    {
        return $query->where('limit_vote', '>', date("Y-m-d H:i:s"))->where('limit_answer', '<', date("Y-m-d H:i:s"))->where("kind", 0);
    }

    public function scopeFinished($query)
    {
        return $query->where('limit_vote', '<', date("Y-m-d H:i:s"))->where("kind", 0);
    }

    public function scopeFast($query)
    {
        return $query->where('kind', 1);
    }

    public function getSituation()
    {
        $limitAnswer = $this->limit_answer;
        $limitVote = $this->limit_vote;
        $now = date('Y-m-d H:i:s');

        if($this->kind === 1)
        {
            $situation = 'fast';
        }elseif($now < $limitAnswer)
        {
            $situation = 'recruting';
        }elseif($limitAnswer < $now && $now < $limitVote)
        {
            $situation = 'voting';
        }else
        {
            $situation = 'finished';
        }
        return $situation;
    }

    public function getMaker()
    {
        return $this->user->name;
    }

    public function getLikeUsers()
    {
        $likeUsers = array();
        for($i=0; $i<count($this->question_likes); $i++)
        {
            if($this->question_likes[$i]->kind === 0)
            {
                $likeUsers[] = $this->question_likes[$i]->user;
            }
        }
        return $likeUsers;
    }

}
