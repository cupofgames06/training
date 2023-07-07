<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Admin\Traits\OfferImage;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\PackResource;
use App\Models\Project;
use App\View\Components\DataTable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use Spatie\Tags\Tag;

class AdminProjectController extends AdminController
{
    use OfferImage;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $projects = Project::with('description')->where('status', '!=', 'deleted')->get();
            $dataTable = new DataTableAPI($projects, $request);
            $dataTable->search(array(
                'search' => array(
                    'description.reference',
                    'description.name',
                    'type',
                    'duration'
                )
            ));
            $dataTable->ordering(array(
                0 => 'description.reference',
                1 => 'description.name',
                2 => 'type',
                3 => 'duration',
            ));
            return $dataTable->result(ProjectResource::class);
        }

        $table = new Table();
        $table->columns(array(
            array(
                'title' => 'Référence',
                'class' => ''
            ),
            array(
                'title' => 'Nom',
                'class' => ''
            ),
            array(
                'title' => 'Modalité',
                'class' => ''
            ),
            array(
                'title' => 'Durée(h)',
                'class' => ''
            ),
            array(
                'title' => 'Détail',
                'orderable' => false,
                'class' => 'dt-right'
            )
        ));

        $table->search(true);

        /*$table->filters(array(
            array(
                'label' => 'Status',
                'items' => array('1', "2"),
            ),
        ));*/

        $table->ajax();

        $table->action(array(
            'class' => 'btn btn-secondary',
            'label' => 'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('of.projects.create'),
        ));

        $tab_nav = projects_tab('projects');

        return view('dashboard.pages.of.projects', compact('table', 'tab_nav'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {

        //Au cas ou gestion image pour une autre offre précédemment affichée, avec upload Ajax TMP mais sans sauvegarde
        Auth::user()->clearMediaCollection('tmp');

        return response()->view('dashboard.pages.of.project-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param $locale
     * @return JsonResponse
     */
    public function store(ProjectRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['project']['of_id'] = Auth::user()->ofs()->first()->id; //todo : of en cours
        $project = Project::create($datas['project']);
        $project->status = 'inactive';
        $project->save();
        $project->description()->create($datas['description']);
        if ($datas['description']['intra'] == 0) {
            $project->setPrices($datas['price']);
        }

        if (!empty($datas['indicators'])) {
            foreach ($datas['indicators'] as $k => $v) {
                if (!empty($v)) {
                    $project->indicators()->attach($k, ['value' => $v]);
                }
            }
        }
        $project->storeImage();

        return response()->json(['redirect' => route('of.projects.edit', [$project]), 'success' => 'Création formation effectuée']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $locale
     * @param int $id
     * @return Response
     */
    public function edit($locale, $id)
    {
        //Au cas ou gestion image pour une autre offre précédemment affichée, avec upload Ajax TMP mais sans sauvegarde
        Auth::user()->clearMediaCollection('tmp');

        $project = Project::find($id);
        $tab_nav = $this->_navtab($project, 'info');
        return response()->view('dashboard.pages.of.project-edit', [
            'project' => $project,
            'tab_nav' => $tab_nav
        ]);
    }

    public function update(ProjectRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $project = Project::find($id);

        //redirection suite à update, si modification d'un champs ci-dessous
        $redirect = $project->type != $datas['project']['type']
            || $project->description->intra != $datas['description']['intra']
            || $project->description->reference != $datas['description']['reference']
            || $project->description->name != $datas['description']['name'][app()->getLocale()]
            || $project->description->pre_requisite_quiz != $datas['description']['pre_requisite_quiz'];

        $project->update($datas['project']);
        $project->description()->update($datas['description']);
        $project->indicators()->detach();
        if (!empty($datas['indicators'])) {
            foreach ($datas['indicators'] as $k => $v) {
                if (!empty($v)) {
                    $project->indicators()->attach($k, ['value' => $v]);
                }
            }
        }

        if ($datas['description']['intra'] == 0) {
            $project->setPrices($datas['price']);
        }

        if (!empty($datas['tag'])) {
            $project->detachTags(Tag::where('type', array_keys($datas['tag']))->get());
            foreach ($datas['tag'] as $type => $values) {
                $tags = Tag::whereIn('id', array_values($datas['tag'][$type]))->get();
                $project->attachTags($tags);
            }
        }

        if (!empty($datas['delete']['offer_image'])) {
            $project->description->clearMediaCollection('image');
        } else {
            $project->updateImage();
        }

        return $redirect ? response()->json(['redirect' => route('of.projects.edit', [$project]), 'success' => 'Mise à jour formation effectuée']) : response()->json(['success' => 'Mise à jour formation effectuée']);
    }

    public function toggle_status($locale, $project, $status): JsonResponse
    {
        $project = Project::find($project);
        $project->update(['status'=>$status]);
        return response()->json(['reload' => true, 'success' => $status == 'active'?'Mise en ligne effectuée':'Retrait effectué']);
    }

    public function destroy($locale, $id)
    {
        //todo vérifier autorisation
        $project = Project::find($id);
        $project->status = 'deleted';
        $project->save();

        return response()->json(['redirect' => route('of.projects.index'), 'success' => 'Suppression formation effectuée']);
    }

    public function access_rules($locale, $id)
    {
        $item = Project::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'access-rules');
        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.projects.access_rules.title')
        ];

        return response()->view('dashboard.pages.of.access-rules', [
            'item' => $item,
            'item_type' => $c->getShortName(),
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);

    }

    public function intras($locale, $id)
    {
        $item = Project::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'intras');
        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.intra_trainings.title')
        ];

        return response()->view('dashboard.pages.of.intra-trainings', [
            'title' => $item->description->reference,
            'subtitle' => $item->description->name,
            'item' => $item,
            'item_type' => $c->getShortName(),
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function supports($locale, $id)
    {
        $item = Project::find($id);
        $tab_nav = $this->_navtab($item, 'supports');
        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.supports.title')
        ];

        $c = new ReflectionClass($item);
        return response()->view('dashboard.pages.of.supports', [
            'title' => $item->description->reference,
            'subtitle' => $item->description->name,
            'item' => $item,
            'item_type' => $c->getShortName(),
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }


    public function pre_requisite_quiz($locale, $project_id, $version_id = null, $page_id = null)
    {
        $item = Project::find($project_id);

        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.projects.tab_nav.prerequisite-quiz')
        ];

        $tab_nav = $this->_navtab($item, 'pre_requisite_quiz');
        $quiz = $item->getPreRequisiteQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;

        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    public function evaluation_quiz($locale, $project_id, $version_id = null, $page_id = null): Response
    {
        $item = Project::find($project_id);

        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.projects.tab_nav.evaluation-quiz'),
        ];

        $tab_nav = $this->_navtab($item, 'evaluation_quiz');
        $quiz = $item->getEvaluationQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;



        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    public function elearning_selection($locale, $project_id): Response
    {
        $project = Project::find($project_id);

        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $project]) => trans('of.projects.edit.title'),
            '#' => trans('of.projects.tab_nav.evaluation-quiz-selection'),
        ];

        $tab_nav = $this->_navtab($project, 'elearning_selection');
        return response()->view('dashboard.pages.of.elearning-selection', [
            'title' => $project->description->reference,
            'subtitle' => $project->description->name,
            'project' => $project,
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }

    public function elearning_quiz($locale, $project_id, $version_id = null, $page_id = null)
    {
        $item = Project::find($project_id);

        $breadcrumbs = [
            route('of.projects.index') => trans('of.projects.index.title'),
            route('of.projects.edit', ['project' => $item]) => trans('of.projects.edit.title'),
            '#' => trans('of.projects.tab_nav.evaluation-quiz'),
        ];

        $tab_nav = $this->_navtab($item, 'evaluation_quiz');
        $quiz = $item->getEvaluationQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;

        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    private function _navtab($project, $selected = ''): array
    {
        $tab_nav = [
            (object)['id' => 'info-tab', 'title' => 'Informations', 'route' => route('of.projects.edit', [$project]), 'selected' => $selected === 'info']
        ];

        if ($project->description->pre_requisite_quiz === 1) {
            $tab_nav[] = (object)['id' => 'pre-requisite-quiz-tab', 'title' => trans('of.projects.tab_nav.prerequisite-quiz'), 'route' => route('of.projects.pre_requisite_quiz', [$project]), 'selected' => $selected === 'pre_requisite_quiz'];
        }

        if ($project->type != 'elearning') {
            $tab_nav[] = (object)['id' => 'evaluation-quiz-tab', 'title' => trans('of.projects.tab_nav.evaluation-quiz'), 'route' => route('of.projects.evaluation_quiz', [$project]), 'selected' => $selected === 'evaluation_quiz'];
        } else {
            $tab_nav[] = (object)['id' => 'module-quiz-tab', 'title' => 'Gestion module', 'route' => route('of.projects.elearning_selection', [$project]), 'selected' => $selected === 'elearning_scorm' || $selected === 'elearning_quiz' || $selected === 'elearning_selection'];
        }

        if ($project->description->intra === 1) {
            $tab_nav[] = (object)[
                'id' => 'intra-tab',
                'route' => route('of.projects.intras', [$project]),
                'title' => trans('of.intra_trainings.title'),
                'selected' => $selected === 'intras'];
        }

        $tab_nav[] = (object)[
            'id' => 'supports-tab',
            'route' => route('of.projects.supports', [$project]),
            'title' => trans('of.supports.title'),
            'selected' => $selected === 'supports'];

        $tab_nav[] = (object)[
            'id' => 'access-rules-tab',
            'route' => route('of.projects.access_rules', [$project]),
            'title' => trans('of.projects.access_rules.title'),
            'selected' => $selected === 'access-rules'];

        return $tab_nav;
    }
}
