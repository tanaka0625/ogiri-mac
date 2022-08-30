<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Answer_like extends Model
{
    use HasFactory;

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAnswerIdEquall($query, $answerId)
    {
        return $query->where('answer_id', $answerId);
    }

    public function scopeKindEquall($query, $kind)
    {
        return $query->where('kind', $kind);
    }

    public function getUserName()
    {
        return $this->user->name;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

}
