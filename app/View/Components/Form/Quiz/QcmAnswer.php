<?php

namespace App\View\Components\Form\Quiz;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class QcmAnswer extends Component
{
    public mixed $module;
    public int $position;
    public array $locales;

    public function __construct($module,$position)
    {
        $this->module = $module;
        $this->position = $position;
        foreach( config('app.supported_locales') as $v) {
            $this->locales[$v] = $v;
        }
    }

    public function html()
    {
        return $this->render()->with(['module'=>$this->module,'position'=>$this->position])->render();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.quiz.modules.question-qcm-answer');
    }

}
