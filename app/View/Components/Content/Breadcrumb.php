<?php

namespace App\View\Components\Content;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $breadcrumbs = [];

    public function __construct($breadcrumbs = [])
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.content._breadcrumb');
    }

}
