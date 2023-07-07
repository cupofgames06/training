<?php

namespace App\Core\Datatable;

use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class Filter
{
    public string $id;
    public string $type = 'dropdown' ;// par défaut
    public string $class = 'btn btn-outline-light'; // par défaut
    public string $label;
    public string $icon = '<i class="fa-regular fa-sliders-simple"></i>'; // par défaut
    public string $placeholder;
    public array|Collection $items;
    public int $column; //numéro de colonne que l'on veut filtrer

    public function __construct(array $item)
    {
        $this->id = 'filter_' . uniqid();
        foreach ($item as $key => $value) {
            $this->$key = $value;
        }

    }
}
