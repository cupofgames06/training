<?php

namespace App\View\Components\Form;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;


class IntraTrainingCard extends Component
{
    public mixed $item;
    public mixed $intra_training;
    public string $name = "";

    public function __construct($item, $intra = null)
    {

        $this->item = $item;
        $this->intra_training = $intra;
        if (!empty($intra)) {
            $this->name = trans('of.trainings.main_price_title');
            if (!empty($intra['companies'])) {
                $name = Company::with('entity')->whereIn('id', $intra['companies'])->get()->pluck('entity.name')->toArray();
                $name = implode(', ', $name);
                $this->name = Str::limit($name, 50);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        return view('components.form.intra-training-card');
    }
}
