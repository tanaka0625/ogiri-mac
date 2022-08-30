<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageLink extends Component
{
    public $pageLink;
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageLink, $url)
    {
        // $this->order = $order;
        // $this->period = $period;
        $this->pageLink = $pageLink;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-link');
    }
}
