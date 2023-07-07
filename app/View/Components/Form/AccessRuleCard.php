<?php

namespace App\View\Components\Form;

use App\Models\ModelAccessRule;
use App\Models\Price;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class AccessRuleCard extends Component
{
    public $item;
    public $access_rule;
    public $name;

    public function __construct($item, $id = 0, $name = '')
    {
        $this->item = $item;
        $this->name = $name;
        if (!empty($id)) {
            $this->access_rule = ModelAccessRule::find($id);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.access-rule-card');
    }
}
