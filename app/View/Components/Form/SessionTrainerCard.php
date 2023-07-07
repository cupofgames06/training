<?php

namespace App\View\Components\Form;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class SessionTrainerCard extends Component
{
    public mixed $item;
    public mixed $session_trainer;


    public function __construct($item, $datas = null)
    {
        $this->item = $item;
        $this->session_trainer = $datas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.session-trainer-card');
    }
}
