<?php

namespace App\View\Components\Form;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use ReflectionClass;


class SupportCard extends Component
{
    public mixed $item;
    public mixed $support;
    public mixed $name = '';
    public string $route_prefix = '';
    /**
     * @throws \ReflectionException
     */
    public function __construct($item, $support = null)
    {
        $this->item = $item;
        $this->support = $support;
        $reflection = new ReflectionClass($this->item::class);
        $this->route_prefix = strtolower($reflection->getShortName()).'s';

        if (!empty($support)) {
            $this->name = $support->name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.support-card');
    }
}
