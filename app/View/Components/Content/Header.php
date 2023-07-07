<?php

namespace App\View\Components\Content;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Header extends Component
{
    public string $title = '';
    public string $sub_title = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $subTitle = null)
    {

        $this->title = !empty($title)?$title:(trans(Route::currentRouteName().'.title')??'');

        $this->sub_title = !empty($subTitle)?$subTitle:'';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.content._header');
    }
}
