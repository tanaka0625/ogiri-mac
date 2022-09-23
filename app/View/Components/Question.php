<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Question extends Component
{
    public $item;
    public $maker;
    public $likeUsers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $maker, $likeUsers)
    {
        $this->item = $item;
        $this->maker = $maker;
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
