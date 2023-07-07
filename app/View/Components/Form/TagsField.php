<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Spatie\Tags\Tag;

class TagsField extends Component
{
    public array $tags;
    public array $selected;
    public string $multiple;

    /**
     * Create a new component instance.
     *
     * @param $group
     * @param array $selected
     */
    public function __construct($group, array $selected = [], bool $multiple = false)
    {

        $this->selected = $selected;
        foreach (custom('tags.' . $group) as $k => $v) {
            $tags = Tag::where('type', $k)->get();
            if (!$multiple) {
                $this->tags[$k][''] = (trans('common.none'));
            }
            foreach ($tags as $t) {
                $name = $t->getTranslation('name', app()->getLocale());
                $this->tags[$k][$t->id] = $name;
            }
        }


        $this->multiple = $multiple;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.tags-field');
    }
}
