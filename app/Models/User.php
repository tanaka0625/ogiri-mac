<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function answer_likes()
    {
        return $this->hasMany(Answer_like::class);
    }

    public function question_likes()
    {
        return $this->hasMany(Question_like::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function clothes()
    {
        return $this->hasMany(Clothe::class);
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getLikedAnswers()
    {
        $likedAnswers = collect();
        for($i=0; $i<count($this->answer_likes); $i++)
        {
            if($this->answer_likes[$i]->kind === 0)
            {
                $likedAnswers[$i] = $this->answer_likes[$i]->getAnswer();
                $likedAnswers[$i]->liked_at = $this->answer_likes[$i]->created_at;
            }

        }

        return $likedAnswers;
    }

    public function getLikedQuestions()
    {
        $likedQuestions = collect();
        for($i=0; $i<count($this->question_likes); $i++)
        {
            if($this->question_likes[$i]->kind === 0)
            {
                $likedQuestions[$i] = $this->question_likes[$i]->getQuestion();
                $likedQuestions[$i]->liked_at = $this->question_likes[$i]->created_at;
            }

        }

        return $likedQuestions;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function getAnswer_likes()
    {
        return $this->answer_likes;
    }
}
