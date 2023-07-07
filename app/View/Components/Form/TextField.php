<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TextField extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $options;
    public $id;

    /**
     * Create a new component instance.
     *
     * @param $label
     * @param $name
     * @param $value
     * @param string $placeholder
     * @param array $options
     */
    public function __construct($label, $name, $id = '', $value = null, $placeholder = "", $options = [])
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.text-field');
    }
}
