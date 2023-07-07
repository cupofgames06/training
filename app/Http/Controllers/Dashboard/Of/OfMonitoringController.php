<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Resources\OfMonitoringCustomerResource;
use App\Http\Resources\OfMonitoringElearningResource;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Resources\OfMonitoringSessionEnrollmentResource;
use App\Http\Resources\OfMonitoringSessionResource;
use App\Models\Company;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Learner;
use App\Models\Pack;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OfMonitoringController extends OfController
{
    public function sessions(Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new DataTableAPI(Session::where('status', '!=', 'deleted')->whereHas('course', function ($query) {
                $query->whereIn('type', ['virtual', 'physical']);
            })->get(), $request);

            $dataTable->search(array(
                'search' => ['date_start',
                    'course.description.reference',
                    'course.description.name',
                    'place',
                    'status']
            ));

            $dataTable->ordering(array(
                0 => 'date_start',
                1 => 'course.description.reference',
                2 => 'course.description.name',
                3 => 'place',
                4 => 'status',
                5 => '-',
                6 => '-',
            ));

            return $dataTable->result(OfMonitoringSessionResource::class);
        }

        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Début formation',
                'class' => ''
            ),
            array(
                'title' => 'Référence',
                'class' => ''
            ),
            array(
                'title' => 'Intitulé',
                'class' => ''
            ),
            array(
                'title' => 'Ville',
                'class' => ''
            ),
            array(
                'title' => 'Statut',
                'class' => ''
            ),
            array(
                'title' => 'Inscrits / Places',
                'class' => ''
            ),
            array(
                'title' => 'Marge',
                'class' => ''
            ),
            array(
                'title' => 'Détail',
                'class' => 'dt-right'
            )
        ));

        $table->ajax();
        $table->search(true);
        $table->filters(
            array(
                array(
                    'label' => 'Type',
                    'items' => array('virtual', 'physical'),
                    'class' => 'btn btn-secondary',
                ),
                array(
                    'class' => 'btn btn-secondary',
                    'label' => 'Status',
                    'items' => Session::STATUS
                )
            )
        );

        return view('dashboard.pages.of.monitoring.sessions', ['table' => $table]);
    }

    public function session_details($locale, Session $session, Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new DataTableAPI(Enrollment::whereHasMorph('enrollmentable', [Session::class], function ($query) use ($session) {
                $query->where('id', $session->id);
            })->get(), $request);

            $dataTable->search(array(
                'search' => 'user.profile.full_name,company.entity.name,created_at',
            ));

            $dataTable->ordering(array(
                0 => 'user.profile.full_name',
                1 => 'company.entity.name',
                2 => 'created_at',
            ));

            return $dataTable->result(OfMonitoringSessionEnrollmentResource::class);
        }
        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Nom / Prénom',
                'class' => ''
            ),
            array(
                'title' => 'Société',
                'class' => ''
            ),
            array(
                'title' => 'Inscription',
                'class' => ''
            ),
            array(
                'title' => 'Présence',
                'class' => ''
            ),
            array(
                'title' => 'Pré-requis',
                'class' => ''
            ),
            array(
                'title' => 'Acquis',
                'class' => ''
            ),
            array(
                'title' => 'Avis',
                'class' => ''
            ),
            array(
                'title' => 'Attestation',
                'class' => ''
            )
        ));

        $table->ajax();
        $table->search(true);

        return view('dashboard.pages.of.monitoring.session-details', [
            'session' => $session,
            'table' => $table
        ]);
    }

    public function customers(Request $request)
    {
        if ($request->ajax()) {

            $dataTable = new DataTableAPI(Company::all(), $request);

            $dataTable->search(array(
                'search' => [
                    'entity.name',
                    'address.postal_code',
                    'address.city',
                ]
            ));

            $dataTable->ordering(array(
                0 => 'entity.name',
                1 => 'address.postal_code',
                2 => 'address.city',
            ));

            return $dataTable->result(OfMonitoringCustomerResource::class);
        }

        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Société',
                'class' => ''
            ),
            array(
                'title' => 'Code Postal',
                'class' => ''
            ),
            array(
                'title' => 'Ville',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable' => false,
                'class' => 'dt-right'
            )
        ));

        $table->ajax();
        $table->search(true);

        return view('dashboard.pages.of.monitoring.customers', ['table' => $table]);
    }

    public function customer_details($locale, Company $company, Request $request)
    {

        $table = new Table();
        $table->columns(array(
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
                'orderable' => false,
                'class' => 'dt-right'
            ),
        ));

        $table->route(route('datatable.of.monitoring.customer.learners.active', ['of' => $this->of, 'company' => $company->id]));
        $table->search(true);

        $table_left = new Table();
        $table_left->columns(array(
            array(
                'title' => 'Nom',
                'class' => ''
            ),
            array(
                'title' => 'Départ de la société',
                'class' => ''
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable' => false,
                'class' => 'dt-right'
            ),
        ));

        $table_left->route(route('datatable.of.monitoring.customer.learners.left', ['of' => $this->of, 'company' => $company->id]));
        $table_left->search(true);

        return view('dashboard.pages.of.monitoring.customer-details', [
            'item' => $company,
            'table' => $table,
            'table_left' => $table_left,
            'count_in' => $company->learners->count(),
            'count_left' => $company->leftLearners->count(),
            'breadcrumb' => array(
                route('of.monitoring.customers') => trans('of.monitoring.customers.title'),
                '#' => $company->entity ? $company->entity->name : null
            )
        ]);
    }

    public function customer_learner_details($locale, $company, $learner)
    {
        $company = Company::find($company);
        if (request()->get('type') == 'left') {
            $learner = $company->leftLearner($learner);
        } else {
            $learner = $company->learner($learner);
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
                'orderable' => false,
                'class' => 'dt-right'
            ),
        ));

        $table->items($learner->enrollments->map(function ($item) use ($learner, $company) {
            return collect([
                $item->enrollmentable->description->name,
                $item->enrollmentable->type ?? $item->enrollmentable->course->type,
                $item->enrollmentable->status,
                convertSecondsToHoursMinutes($item->enrollmentable->duration),
                '80%',
                '20/11/2023',
                view('components.datatable.action._body', ['route' => $item->enrollmentable->monitoringUrl($learner, $company, request()->get('type'))])->render()
            ]);
        }));
        $table->title('Formations');
        return response()->view('dashboard.pages.of.monitoring.customer-learner-details', [
            'learner' => $learner,
            'item' => $company,
            'title' => 'Suivi de ' . $learner->profile->full_name,
            'breadcrumb' => array(
                route('of.monitoring.customers') => trans('of.monitoring.customers.title'),
                route('of.monitoring.customer.details', $company) => $company->entity ? $company->entity->name : null,
                '#' => $learner->profile->full_name
            ),
            'table' => $table
        ]);
    }

    public function elearnings(Request $request)
    {
        if ($request->ajax()) {

            $dataTable = new DataTableAPI(Enrollment::whereHasMorph('enrollmentable', [Course::class], function ($query) {
                $query->where('status', '!=', 'deleted');
            })->get(), $request);

            $dataTable->search(array(
                'search' => [
                    'date_start',
                    'date_attestation',
                    'enrollmentable.description.reference',
                    'company.entity.name',
                    'user.profile.full_name',
                    'status']
            ));

            $dataTable->ordering(array(
                0 => 'date_start',
                1 => 'date_attestation',
                2 => 'enrollmentable.description.reference',
                3 => 'company.entity.name',
                4 => 'user.profile.full_name',
                5 => 'status',
                6 => '-',
                7 => '-'
            ));

            return $dataTable->result(OfMonitoringElearningResource::class);
        }

        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Date commande',
                'class' => ''
            ),
            array(
                'title' => 'Date attestation',
                'class' => ''
            ),
            array(
                'title' => 'Réf; formation',
                'class' => ''
            ),
            array(
                'title' => 'Société',
                'class' => ''
            ),
            array(
                'title' => 'Apprenant',
                'class' => ''
            ),
            array(
                'title' => 'Statut',
                'class' => ''
            ),
            array(
                'title' => 'Acquis(%)',
                'class' => ''
            ),
            array(
                'title' => 'Evaluation',
                'class' => ''
            ),
            array(
                'title' => 'Détail',
                'class' => 'dt-right'
            )
        ));

        $table->ajax();
        $table->search(true);
        $table->filters(
            array(
                array(
                    'label' => 'Status',
                    'items' => Course::STATUS,
                    'class' => 'btn btn-secondary',
                )
            )
        );

        return view('dashboard.pages.of.monitoring.elearnings', ['table' => $table]);
    }

    public function elearning_details($locale, Enrollment $enrollment, Request $request)
    {
        return view('dashboard.pages.of.monitoring.elearning-details', [
            'enrollment' => $enrollment,
        ]);
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
        if (!empty($session)) {
            $startDate = $session->date_start;
            $currentDate = Carbon::now();
            $totalDuration = $session->duration / 60; // en minutes

            if ($currentDate > $startDate) {
                $elapsedDuration = $currentDate->diffInMinutes($startDate);
                $progress = ($elapsedDuration / $totalDuration) * 100;
            } else {
                $progress = 0;
            }
        } else {
            $progress = 0;
        }

        $breadcrumbs = array(
            route('of.monitoring.customers') => trans('of.monitoring.customers.title'),
            route('of.monitoring.customer.details', $company) => $company->entity ? $company->entity->name : null,
            route('of.monitoring.customer.leaner.details', ['locale' => app()->getLocale(), 'company' => $company, 'learner' => $learner, 'type' => request()->get('type')]) => $learner->profile->full_name,
            '#' => !empty($session) ? $session->description->name : $course->description->name
        );

        $monitoring = true;

        $main = view('front.pages.offers.partial.' . $course->type, compact('course', 'session', 'monitoring'))->render();
        $side = view('front.pages.offers.partial.card.aside', ['course' => $course, 'session' => $session, 'monitoring' => $monitoring, 'progress' => $progress, 'learner' => $learner]);
        return view('dashboard.partials.offers.show', compact('main', 'side', 'breadcrumbs', 'monitoring'));
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
