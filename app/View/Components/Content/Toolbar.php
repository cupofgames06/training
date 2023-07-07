<?php

namespace App\View\Components\Content;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Toolbar extends Component
{
    public array $options = [];
    public bool $canSelect = false;
    public $model = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if( auth()->check() && !empty(Cache::get('account'))) {
            $user = auth()->user();

            $this->options = $user->ofs->concat($user->companies)->transform(function ($item, int $key) {
                return array(
                    'id' => $item->id,
                    'model' => get_class($item),
                    'route' => strtolower(class_basename($item)),
                    'selected' => $item->is(Cache::get('account')->model::find(Cache::get('account')->id))
                );
            })->toArray();

            $this->canSelect = count($this->options) > 1;
            if (!empty(Cache::get('account'))) {
                $this->model = class_basename(Cache::get('account')->model::find(Cache::get('account')->id));
            }
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.content._toolbar');
    }
    public function is($model): bool
    {
        return ! is_null($model) &&
            $this->getKey() === $model->getKey() &&
            $this->getTable() === $model->getTable() &&
            $this->getConnectionName() === $model->getConnectionName();
    }
}
