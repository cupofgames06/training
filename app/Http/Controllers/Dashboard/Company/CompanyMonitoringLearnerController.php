<?php

namespace App\Http\Controllers\Dashboard\Company;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Requests\LearnerRequest;
use App\Http\Resources\CompanyActiveLearnerMonitoringResource;
use App\Http\Resources\CompanyActiveLearnerResource;
use App\Http\Resources\CompanyBestCoursesResource;
use App\Http\Resources\CompanyLeftLearnerMonitoringResource;
use App\Http\Resources\CompanyLeftLearnerResource;
use App\Models\Company;
use App\Models\Course;
use App\Models\Learner;
use App\Models\Pack;
use App\Models\Session;
use App\View\Components\DataTable;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Spatie\Tags\Tag;

class CompanyMonitoringLearnerController extends CompanyController
{
    public function index(Request $request): View|Factory|array|Application
    {
        $table_in = new Table();

        $table_in->columns(array(
            array(
                'title' => 'Nom',
                'class' => ''
            ),
            array(
                'title' => 'Total',
                'class' => ''
            ),
            array(
                'title' => 'Réalisé',
                'class' => ''
            ),
            array(
                'title' => 'En cours',
                'class' => ''
            ),
            array(
                'title' => 'A venir',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            ),
        ));
        $table_in->search(true);
        $table_in->filters(
            array(
                array(
                    'label' => 'Service',
                    'items' => Tag::where('type', 'service')->get()->pluck('name', 'id'),

                ),
                array(
                    'label' => 'Fonction',
                    'items' => Tag::where('type', 'function')->get()->pluck('name', 'id'),
                )
            )
        );
        $table_in->route(route('datatable.company.learners.active'));

        $table_left = new Table();

        $table_left->columns(array(
            array(
                'title' => 'Nom',
                'class' => ''
            ),
            array(
                'title' => 'Total',
                'class' => ''
            ),
            array(
                'title' => 'Réalisé',
                'class' => ''
            ),
            array(
                'title' => 'En cours',
                'class' => ''
            ),
            array(
                'title' => 'A venir',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            ),
        ));
        $table_left->search(true);
        $table_left->filters(
            array(
                array(
                    'label' => 'Service',
                    'items' => Tag::where('type', 'service')->get()->pluck('name', 'id'),
                ),
                array(
                    'label' => 'Fonction',
                    'items' => Tag::where('type', 'function')->get()->pluck('name', 'id'),
                )
            )
        );

        $table_left->route(route('datatable.company.learners.left'));

        $count_in = $this->company->learners->count();
        $count_left = $this->company->leftLearners->count();

        return view('dashboard.pages.company.monitoring.learners', compact('table_in', 'table_left', 'count_in', 'count_left'));
    }

    public function details($locale, $id): Response|array
    {
        if(request()->get('type') == 'left')
        {
            $learner = $this->company->leftLearner($id);
        }
        else
        {
            $learner = $this->company->learner($id);
        }


        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Intitulé formation',
                'class' => ''
            ),
            array(
                'title' => 'Modalité',
                'class' => ''
            ),
            array(
                'title' => 'Status',
                'class' => ''
            ),
            array(
                'title' => 'Durée',
                'class' => ''
            ),
            array(
                'title' => 'Acquis',
                'class' => ''
            ),
            array(
                'title' => 'Date',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            ),
        ));
        $table->items($learner->enrollments->map(function ($item) use($learner){
            return collect([
                $item->enrollmentable->description->name,
                $item->enrollmentable->type??$item->enrollmentable->course->type,
                $item->enrollmentable->status,
                convertSecondsToHoursMinutes($item->enrollmentable->duration),
                '80%',
                '20/11/2023',
                view('components.datatable.action._body', ['route' => $item->enrollmentable->monitoringUrl($learner,$this->company,request()->get('type'))])->render()
            ]);
        }));

        return response()->view('dashboard.pages.company.monitoring.learner-details', [
            'learner' => $learner,
            'title' => 'Suivi de ' . $learner->profile->full_name,
            'breadcrumb' => array(
                url()->previous() => 'Suivi',
                '#' => $learner->profile->full_name
            ),
            'table' => $table
        ]);
    }

    public function details_ratings(Request $request)
    {
        $dateDebut = Carbon::parse($request->get('date_start'));
        $dateFin = Carbon::parse($request->get('date_end'));
        $learner = Learner::find($request->get('learner'));
        return view('dashboard.partials._average-ratings', ['item' => $learner, 'from' => $dateDebut, 'to' => $dateFin]);
    }
    public function pack($locale, $pack_id, $preview = false): Factory|View|Application
    {
        $pack = Pack::find($pack_id);
        $main = view('front.pages.offers.partial.pack', compact('pack'))->render();
        $side = view('front.pages.offers.partial.card.pack-aside', ['pack' => $pack]);
        $breadcrumbs = ['home' => 'Nos formations', '#' => $pack->name];


        return view('dashboard.partials.offers.show', compact('main', 'side', 'breadcrumbs'));
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

        $learner = Learner::find(request()->get('learner'));
        $company = Company::find(request()->get('company'));

        // progress pour session
        if(!empty($session))
        {
            $startDate = $session->date_start;
            $currentDate = Carbon::now();
            $totalDuration = $session->duration / 60; // en minutes

            if($currentDate > $startDate)
            {
                $elapsedDuration = $currentDate->diffInMinutes($startDate);
                $progress = ($elapsedDuration / $totalDuration) * 100;
            }
            else
            {
                $progress = 0;
            }
        }
        else
        {
            $progress = 0;
        }

        $breadcrumbs = array(

        );

        $monitoring = true;

        $main = view('front.pages.offers.partial.' . $course->type, compact('course', 'session','monitoring'))->render();
        $side = view('front.pages.offers.partial.card.aside', ['course' => $course, 'session' => $session, 'monitoring' => $monitoring,'progress' => $progress,'learner' => $learner]);
        return view('dashboard.partials.offers.show', compact('main', 'side', 'breadcrumbs','monitoring'));
    }

    public function pack_content($locale, $pack_id): Factory|View|Application
    {
        $pack = Pack::find($pack_id);


        $main = view('front.pages.offers.partial.pack-content', compact('pack'))->render();
        $side = view('front.pages.offers.partial.card.pack-aside', compact('pack'));
        $breadcrumbs = ['home' => 'Nos formations', '#' => $pack->description->name];

        return view('dashboard.partials.offers.show', compact('main', 'side', 'breadcrumbs'));
    }
}
