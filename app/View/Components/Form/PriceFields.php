<?php

namespace App\View\Components\Form;

use App\Models\Price;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use mysql_xdevapi\Collection;

class PriceFields extends Component
{
    public $price;
    public $id;
    public $price_level_id;

    public function __construct($price = [], $id = 'price_fields', $priceLevelId = 1)
    {
        $this->price = $price;
        $this->price_level_id = $priceLevelId;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.price-fields');
    }
}
