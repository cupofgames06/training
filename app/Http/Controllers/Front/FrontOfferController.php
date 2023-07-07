<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Learner;
use App\Models\Pack;
use App\Models\Session;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FrontOfferController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('front.pages.offers.index');
    }

    public function pack($locale, $pack_id, $preview = false): Factory|View|Application
    {
        $pack = Pack::find($pack_id);
        $main = view('front.pages.offers.partial.pack', compact('pack'))->render();
        $side = view('front.pages.offers.partial.card.pack-aside', ['pack' => $pack]);
        $breadcrumbs = ['home' => 'Nos formations', '#' => $pack->description->name];

        $preview = [];
        if (!empty(request()->get('preview'))) {
            $preview['editor_url'] = $pack->editor_url;
        }

        return view('front.pages.offers.show', compact('main', 'side', 'preview', 'breadcrumbs'));
    }

    public function session($locale, $session_id): Factory|View|Application
    {
        $session = Session::find($session_id);
        return $this->course($locale, $session->course_id, $session_id);
    }

    public function course($locale, $course_id, $session_id = null): Factory|View|Application
    {
        $course = Course::find($course_id);
        $session = !empty($session_id) ? Session::find($session_id) : null;
        $preview = [];
        if (!empty(request()->get('preview'))) {
            $preview['editor_url'] = !empty($session_id) ? $session->editor_url : $course->editor_url;
            if ($course->type != 'elearning' && empty($session)) {
                $session = $course->sessions->first();
                if( empty($session)){
                    //todo : filtrer :seulement session de l'of en cours
                    $session = Session::first();
                }
            }
        }

        $breadcrumbs = ['home' => 'Nos formations', '#' => $course->description->name];

        $main = view('front.pages.offers.partial.' . $course->type, compact('course', 'session'))->render();
        $side = view('front.pages.offers.partial.card.aside', ['course' => $course, 'session' => $session]);

        return view('front.pages.offers.show', compact('main', 'side', 'preview', 'breadcrumbs'));
    }

    public function pack_content($locale, $pack_id): Factory|View|Application
    {
        $pack = Pack::find($pack_id);
        $preview = [];
        if (!empty(request()->get('preview'))) {
            $preview['editor_url'] = $pack->editor_url;
        }

        $main = view('front.pages.offers.partial.pack-content', compact('pack'))->render();
        $side = view('front.pages.offers.partial.card.pack-aside', compact('pack'));
        $breadcrumbs = ['home' => 'Nos formations', '#' => $pack->description->name];

        return view('front.pages.offers.show', compact('main', 'side', 'preview', 'breadcrumbs'));
    }

    public function trainers($locale, $session_id): Factory|View|Application
    {
        $session = !empty($session_id) ? Session::find($session_id) : null;
        $course = Course::find($session->course_id);

        $preview = [];
        if (!empty(request()->get('preview'))) {
            $preview['editor_url'] = !empty($session_id) ? $session->editor_url : $course->editor_url;
        }

        $main = view('front.pages.offers.partial.trainers', compact('course','session'))->render();
        $side = view('front.pages.offers.partial.card.aside', ['course' => $course, 'session' => $session]);
        $breadcrumbs = ['home' => 'Nos formations', '#' => $course->description->name];



        return view('front.pages.offers.show', compact('main', 'side', 'preview', 'breadcrumbs'));
    }
}


