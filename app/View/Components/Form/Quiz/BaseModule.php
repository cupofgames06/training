<?php

namespace App\View\Components\Form\Quiz;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseModule extends Component
{
    public mixed $module;
    public mixed $template;
    public array $locales;

    public function __construct($module)
    {
        $this->module = $module;
        $this->template = $this->getTemplate();
        foreach( config('app.supported_locales') as $v) {
            $this->locales[$v] = $v;
        }
    }

    public function getTemplate()
    {
       // return view('components.form.quiz.modules.content-quote',['module' =>  $this->module])->render();
        return view('components.form.quiz.modules.'.$this->module->type.'-'.$this->module->subtype,['module' =>  $this->module])->render();
    }

    public function html()
    {
        return $this->render()->with(['module'=>$this->module,'template' => $this->template])->render();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.quiz.base-module');
    }

}
