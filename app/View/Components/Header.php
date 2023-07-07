<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $type)
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        if($this->type == 'auth')
        {
            return view('dashboard.components.header');
        }
        else
        {
            return view('front.components.header');
        }
    }
}
