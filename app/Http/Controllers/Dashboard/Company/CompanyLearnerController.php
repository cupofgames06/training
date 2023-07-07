<?php

namespace App\Http\Controllers\Dashboard\Company;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Requests\LearnerRequest;
use App\Http\Resources\CompanyActiveLearnerMonitoringResource;
use App\Http\Resources\CompanyActiveLearnerResource;
use App\Http\Resources\CompanyLeftLearnerMonitoringResource;
use App\Http\Resources\CompanyLeftLearnerResource;
use App\Models\Course;
use App\Models\Learner;
use App\Models\ModelHasUser;
use App\View\Components\DataTable;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Spatie\Tags\Tag;

class CompanyLearnerController extends CompanyController
{

    public function getActiveLearners(Request $request)
    {
        $dataTable = new DataTableAPI($this->company->learners, $request);

        $dataTable->search(array(
            'search' => 'profile.full_name',
            'fonction' => 'description.job_title',
            'service' => 'description.service',
        ));
        $dataTable->ordering(array(
            0 => 'profile.full_name',
            1 => 'description.date_start',
            2 => 'description.job_title',
            3 => 'description.service',
        ));

        if (Str::contains($request->server('HTTP_REFERER'), 'monitoring')) {
            return $dataTable->result(CompanyActiveLearnerMonitoringResource::class);
        } else {
            return $dataTable->result(CompanyActiveLearnerResource::class);
        }

    }

    public function getLearnersLeft(Request $request)
    {
        $dataTable = new DataTableAPI($this->company->leftLearners, $request);

        $dataTable->ordering(array(
            0 => 'profile.full_name',
            1 => 'history.date_start',
            2 => 'history.date_end',
            3 => 'history.job_title',
            4 => 'history.service',
        ));

        $dataTable->search(array(
            'search' => 'profile.full_name',
            'fonction' => 'history.job_title',
            'service' => 'history.service',
        ));

        if (Str::contains($request->server('HTTP_REFERER'), 'monitoring')) {
            return $dataTable->result(CompanyLeftLearnerMonitoringResource::class);
        } else {
            return $dataTable->result(CompanyLeftLearnerResource::class);
        }
    }

    public function index(Request $request): View|Factory|array|Application
    {

        $table_left = new Table();

        // ajouter les colonnes de la datatables
        $table_left->columns(array(
            array(
                'title' => 'Nom',
                'data' => 'profile.full_name',
                'name' => 'nom',
                'class' => '',
            ),
            array(
                'title' => 'Date Arrivée',
                'data' => 'description.date_start',
                'name' => 'date_start',
                'class' => '',
            ),
            array(
                'title' => 'Date Sortie',
                'name' => 'date_end',
                'class' => ''
            ),
            array(
                'title' => 'Fonction',
                'data' => 'description.job_title',
                'name' => 'job_title',
                'class' => '',
            ),
            array(
                'title' => 'Service',
                'data' => 'description.service',
                'name' => 'service',
                'class' => '',
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            )
        ));

        $table_left->search(true);

        $table_left->filters(array(
            array(
                'label' => 'Service',
                'items' => Tag::where('type', 'service')->get()->pluck('name', 'id'),
            ),
            array(
                'label' => 'Fonction',
                'items' => Tag::where('type', 'function')->get()->pluck('name', 'id'),
            ),
        ));

        $table_left->route(route('datatable.company.learners.left'));

        $table_in = new Table();
        $table_in->columns(array(
            array(
                'title' => 'Nom',
                'name' => 'profile.full_name',
                'class' => '',
            ),
            array(
                'title' => 'Date Arrivé',
                'name' => 'date_start',
                'class' => '',
            ),
            array(
                'title' => 'Fonction',
                'name' => 'job_title',
                'class' => '',
            ),
            array(
                'title' => 'Service',
                'name' => 'service',
                'class' => '',
            ),
            array(
                'title' => trans('common.details'),
                'name' => 'detail',
                'class' => 'dt-right'
            )
        ));

        $table_in->search(true);

        $table_in->filters(array(
            array(
                'label' => 'Service',
                'items' => Tag::where('type', 'service')->get()->pluck('name', 'id'),
            ),
            array(
                'label' => 'Fonction',
                'items' => Tag::where('type', 'function')->get()->pluck('name', 'id'),
            ),
        ));

        $table_in->route(route('datatable.company.learners.active'));

        $table_in->action(array(
            'class' => 'btn btn-secondary',
            'label' => 'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('company.learners.create'),
        ));

        $count_in = $this->company->learners->count();
        $count_left = $this->company->leftLearners->count();

        return view('dashboard.pages.company.learners', compact('table_in', 'table_left', 'count_in', 'count_left'));
    }

    public function monitoring()
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
            )
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
            )
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

        return view('dashboard.pages.company.learners', compact('table_in', 'table_left', 'count_in', 'count_left'));
    }

    public function monitoring_details($locale, $id, Request $request): Response|array
    {
        $learner = $this->company->learners_activity_logs()->find($id);

        $table = new DataTable();
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

        $table->items(Course::all()->map(function ($item) {
            return collect([
                $item->name,
                $item->type,
                $item->status,
                $item->duration,
                '80%',
                '20/11/2023',
                view('components.datatable.action._body', ['route' => '#'])->render()
            ]);
        }));

        return response()->view('dashboard.pages.company.learner_monitoring', [
            'learner' => $learner,
            'title' => 'Suivi de ' . $learner->profile->full_name,
            'breadcrumb' => array(
                url()->previous() => 'Suivi',
                '#' => $learner->profile->full_name
            ),
            'table' => $table->render()->with($table->data())
        ]);
    }

    public function monitoring_details_ratings(Request $request)
    {
        $dateDebut = Carbon::parse($request->get('date_start'));
        $dateFin = Carbon::parse($request->get('date_end'));
        $learner = Learner::find($request->get('learner'));
        return view('dashboard.partials._average-ratings', ['item' => $learner, 'from' => $dateDebut, 'to' => $dateFin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('dashboard.pages.company.learner-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LearnerRequest $request
     * @param $locale
     * @return JsonResponse
     */
    public function store(LearnerRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        //todo : si doublon return error, sinon envoi de mail ouverture de compte

        $learner = Learner::create($datas['user']);
        $learner->assignRole('learner');
        $learner->profile()->create($datas['profile']);
        $learner->description()->create($datas['description']);

        $tags = Tag::whereIn('id', array_values(array_merge($datas['tag']['function'], $datas['tag']['service'])))->get();
        $learner->description->attachTags($tags);

        $this->company->addUser($learner->id);

        return response()->json(['redirect' => route('company.learners.edit', [$learner]), 'success' => 'Création effectuée']);
    }

    public function edit($locale, $id): Response
    {

        $learner = $this->company->learner($id);
        return response()->view('dashboard.pages.company.learner-edit', [
            'learner' => $learner
        ]);
    }

    public function update(LearnerRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        //todo : si doublon return error

        $learner = $this->company->learner($id);
        $learner->profile->update($datas['profile']);
        if (empty($datas['user']['password'])) {
            unset($datas['user']['password']);
        } else {
            $datas['user']['password'] = Hash::make($datas['user']['password']);
        }

        $learner->update($datas['user']);
        $learner->description->update($datas['description']);

        $learner->description->detachTags(Tag::where('type', array_keys($datas['tag']))->get());
        $tags = Tag::whereIn('id', array_values(array_merge($datas['tag']['function'], $datas['tag']['service'])))->get();
        $learner->description->attachTags($tags);

        return response()->json(['success' => 'mise à jour effectuée']);
    }


    public function destroy($id)
    {

    }

}
