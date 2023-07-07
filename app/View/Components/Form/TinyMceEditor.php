<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class tinyMceEditor extends Component
{
    public string $id;
    public string $name;
    public mixed $value;
    public bool $is_module = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $name = '', $value = '', $module = false)
    {
        $this->id = $id;
        $this->name = !empty($name) ? $name : $id;
        $this->value = $value;
        $this->is_module = $module;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.tinymce-editor');
    }
}
