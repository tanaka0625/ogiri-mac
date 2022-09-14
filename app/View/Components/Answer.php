<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Answer extends Component
{

    public $text;
    public $maker;
    public $like;
    public $vote;
    public $questionText;
    public $questionId;
    public $btnType;
    public $likeUserNames;
    public $userId;
    public $questionSituation;
    public $kind;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $maker, $like, $vote, $questionText, $questionId, $btnType, $likeUserNames, $userId, $questionSituation, $kind)
    {
        $this->text = $text;
        $this->maker = $maker;
        $this->like = $like;
        $this->vote = $vote;
        $this->questionText = $questionText;
        $this->questionId = $questionId;
        $this->btnType = $btnType;
        $this->likeUserNames = $likeUserNames;
        $this->userId = $userId;
        $this->questionSituation = $questionSituation;
        $this->kind = $kind;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.answer');
    }
}
