<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TranslatedInlineField extends Component
{

    public array $values;
    public string $id;
    public string $name;
    public string $label;
    public array $locales;

    public function __construct($label, $name, $id = '', $values = [])
    {
        $this->label = $label;
        $this->id = !empty($id)?$id:str_replace(['[',']'], '_',$name);
        $this->name = $name;
        $this->values = $values;
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
        return view('components.form.translated-inline-field');
    }
}
