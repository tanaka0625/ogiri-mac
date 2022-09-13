<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Page extends Component
{
    public $pageLinks;
    public $maxPage;
    public $url;
    public $page;
    public $previousPage;
    public $nextPage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageLinks, $maxPage, $url, $page)
    {
        $this->pageLinks = $pageLinks;
        $this->maxPage = $maxPage;
        $this->url = $url;
        $this->page = $page;
        $this->previousPage = $page -1;
        $this->nextPage = $page +1;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page');
    }
}
