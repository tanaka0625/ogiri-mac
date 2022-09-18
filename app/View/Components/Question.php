<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Question extends Component
{
    public $text;
    public $maker;
    public $like;
    public $answerNumber;
    public $imgName;
    public $questionId;
    public $userId;
    public $likeUsers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $maker, $like, $answerNumber, $imgName, $questionId, $userId, $likeUsers)
    {
        $this->text = $text;
        $this->maker = $maker;
        $this->like = $like;
        $this->answerNumber = $answerNumber;
        $this->imgName = $imgName;
        $this->questionId = $questionId;
        $this->userId = $userId;
        $this->likeUsers = $likeUsers;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.question');
    }
}
