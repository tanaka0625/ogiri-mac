<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Answer extends Component
{

    public $item;
    public $questionText;
    public $btnType;
    public $likeUsers;
    public $voteUsers;
    public $questionSituation;
    public $maker;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item ,$questionText, $btnType, $likeUsers, $voteUsers, $questionSituation, $maker)
    {

        $this->item = $item;
        $this->questionText = $questionText;
        $this->btnType = $btnType;
        $this->likeUsers = $likeUsers;
        $this->voteUsers = $voteUsers;
        $this->questionSituation = $questionSituation;
        $this->maker = $maker;
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
