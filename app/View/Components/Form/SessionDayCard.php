<?php

namespace App\View\Components\Form;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class SessionDayCard extends Component
{
    public mixed $session;
    public mixed $day;

    public function __construct($session, $sessionDay = [])
    {
        $this->session = $session;
        $this->day = $sessionDay;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.session-day-card');
    }
}
