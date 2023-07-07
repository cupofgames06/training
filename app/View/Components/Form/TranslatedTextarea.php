<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TranslatedTextarea extends Component
{


    public array $values;
    public string $id;
    public string $name;
    public string $label;
    public array $locales;
    public bool $is_module = false;

    public function __construct($label, $name, $id = '', $values = [], $module = false)
    {
        $this->label = $label;
        $this->id = !empty($id)?$id:str_replace(['[',']'], '_',$name);
        $this->name = $name;
        $this->values = $values;
        $this->is_module = $module;

        foreach( config('app.supported_locales') as $v) {
            $this->locales[$v] = $v;
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.translated-textarea');
    }
}
