<?php

namespace App\View\Components\Content;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class NavTab extends Component
{
    public array $items = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.content._nav-tab');
    }
}
