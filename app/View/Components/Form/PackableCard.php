<?php

namespace App\View\Components\Form;

use App\Models\Course;
use App\Models\ModelAccessRule;
use App\Models\Packable;
use App\Models\Price;
use App\Models\Session;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class PackableCard extends Component
{
    public $pack;
    public $name;
    public mixed $packable = null;

    public function __construct($pack, $packable = null)
    {
        $this->pack = $pack;
        $this->name = '';
        if (!empty($packable)) {
            $this->packable = $packable;


            switch ($this->packable::class) {
                case 'App\Models\Course':
                    $this->name = $this->packable->title();
                    break;

                case 'App\Models\Session':
                    $this->name = $this->packable->course->description->reference . ' - ' . $this->packable->subtitle();
                    break;
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
        return view('components.form.packable-card');
    }

    public function elearningList()
    {
        $elearnings = $this->pack->elearnings()->pluck('packable_id')->toArray();
        return Course::getList($elearnings, 'elearning');
    }

    public function sessionList()
    {
        $sessions = $this->pack->ordered_sessions()->pluck('id')->toArray();
        return Session::getList($sessions);
    }
}
