<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Of\Traits\OfferImage;
use App\Http\Controllers\Dashboard\Of\Traits\Quizzes;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\PackResource;
use App\Models\Course;
use App\Models\ModelAccessRule;
use App\Models\Pack;
use App\Models\QuizVersion;
use App\View\Components\DataTable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use Spatie\Tags\Tag;

class OfCourseController extends OfController
{
    use Quizzes;
    use OfferImage;

    public function index(Request $request)
    {


        if ($request->ajax()) {
            $courses = Course::with('description')->where('status', '!=', 'deleted')->get();
            $dataTable = new DataTableAPI($courses, $request);
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
            return $dataTable->result(CourseResource::class);
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
            'route' => route('of.courses.create'),
        ));

        $tab_nav = courses_tab('courses');

        return view('dashboard.pages.of.courses', compact('table', 'tab_nav'));
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

        return response()->view('dashboard.pages.of.course-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param $locale
     * @return JsonResponse
     */
    public function store(CourseRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['course']['of_id'] = Auth::user()->ofs()->first()->id; //todo : of en cours
        $course = Course::create($datas['course']);
        $course->status = 'inactive';
        $course->save();
        $course->description()->create($datas['description']);
        if ($datas['description']['intra'] == 0) {
            $course->setPrices($datas['price']);
        }

        if (!empty($datas['indicators'])) {
            foreach ($datas['indicators'] as $k => $v) {
                if (!empty($v)) {
                    $course->indicators()->attach($k, ['value' => $v]);
                }
            }
        }
        $course->storeImage();

        return response()->json(['redirect' => route('of.courses.edit', [$course]), 'success' => 'Création formation effectuée']);
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

        $course = Course::find($id);
        $tab_nav = $this->_navtab($course, 'info');
        return response()->view('dashboard.pages.of.course-edit', [
            'course' => $course,
            'tab_nav' => $tab_nav
        ]);
    }

    public function update(CourseRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $course = Course::find($id);

        //redirection suite à update, si modification d'un champs ci-dessous
        $redirect = $course->type != $datas['course']['type']
            || $course->description->intra != $datas['description']['intra']
            || $course->description->reference != $datas['description']['reference']
            || $course->description->name != $datas['description']['name'][app()->getLocale()]
            || $course->description->pre_requisite_quiz != $datas['description']['pre_requisite_quiz'];

        $course->update($datas['course']);
        $course->description()->update($datas['description']);
        $course->indicators()->detach();
        if (!empty($datas['indicators'])) {
            foreach ($datas['indicators'] as $k => $v) {
                if (!empty($v)) {
                    $course->indicators()->attach($k, ['value' => $v]);
                }
            }
        }

        if ($datas['description']['intra'] == 0) {
            $course->setPrices($datas['price']);
        }

        if (!empty($datas['tag'])) {
            $course->detachTags(Tag::where('type', array_keys($datas['tag']))->get());
            foreach ($datas['tag'] as $type => $values) {
                $tags = Tag::whereIn('id', array_values($datas['tag'][$type]))->get();
                $course->attachTags($tags);
            }
        }

        if (!empty($datas['delete']['offer_image'])) {
            $course->description->clearMediaCollection('image');
        } else {
            $course->updateImage();
        }

        return $redirect ? response()->json(['redirect' => route('of.courses.edit', [$course]), 'success' => 'Mise à jour formation effectuée']) : response()->json(['success' => 'Mise à jour formation effectuée']);
    }

    public function toggle_status($locale, $course, $status): JsonResponse
    {
        $course = Course::find($course);
        $course->update(['status'=>$status]);
        return response()->json(['reload' => true, 'success' => $status == 'active'?'Mise en ligne effectuée':'Retrait effectué']);
    }

    public function destroy($locale, $id)
    {
        //todo vérifier autorisation
        $course = Course::find($id);
        $course->status = 'deleted';
        $course->save();

        return response()->json(['redirect' => route('of.courses.index'), 'success' => 'Suppression formation effectuée']);
    }

    public function access_rules($locale, $id)
    {
        $item = Course::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'access-rules');
        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
            '#' => trans('of.courses.access_rules.title')
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
        $item = Course::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'intras');
        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
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
        $item = Course::find($id);
        $tab_nav = $this->_navtab($item, 'supports');
        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
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


    public function pre_requisite_quiz($locale, $course_id, $version_id = null, $page_id = null)
    {
        $item = Course::find($course_id);

        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
            '#' => trans('of.courses.tab_nav.prerequisite-quiz')
        ];

        $tab_nav = $this->_navtab($item, 'pre_requisite_quiz');
        $quiz = $item->getPreRequisiteQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;

        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    public function evaluation_quiz($locale, $course_id, $version_id = null, $page_id = null): Response
    {
        $item = Course::find($course_id);

        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
            '#' => trans('of.courses.tab_nav.evaluation-quiz'),
        ];

        $tab_nav = $this->_navtab($item, 'evaluation_quiz');
        $quiz = $item->getEvaluationQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;



        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    public function elearning_selection($locale, $course_id): Response
    {
        $course = Course::find($course_id);

        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $course]) => trans('of.courses.edit.title'),
            '#' => trans('of.courses.tab_nav.evaluation-quiz-selection'),
        ];

        $tab_nav = $this->_navtab($course, 'elearning_selection');
        return response()->view('dashboard.pages.of.elearning-selection', [
            'title' => $course->description->reference,
            'subtitle' => $course->description->name,
            'course' => $course,
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }

    public function elearning_quiz($locale, $course_id, $version_id = null, $page_id = null)
    {
        $item = Course::find($course_id);

        $breadcrumbs = [
            route('of.courses.index') => trans('of.courses.index.title'),
            route('of.courses.edit', ['course' => $item]) => trans('of.courses.edit.title'),
            '#' => trans('of.courses.tab_nav.evaluation-quiz'),
        ];

        $tab_nav = $this->_navtab($item, 'evaluation_quiz');
        $quiz = $item->getEvaluationQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;

        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    private function _navtab($course, $selected = ''): array
    {
        $tab_nav = [
            (object)['id' => 'info-tab', 'title' => 'Informations', 'route' => route('of.courses.edit', [$course]), 'selected' => $selected === 'info']
        ];

        if ($course->description->pre_requisite_quiz === 1) {
            $tab_nav[] = (object)['id' => 'pre-requisite-quiz-tab', 'title' => trans('of.courses.tab_nav.prerequisite-quiz'), 'route' => route('of.courses.pre_requisite_quiz', [$course]), 'selected' => $selected === 'pre_requisite_quiz'];
        }

        if ($course->type != 'elearning') {
            $tab_nav[] = (object)['id' => 'evaluation-quiz-tab', 'title' => trans('of.courses.tab_nav.evaluation-quiz'), 'route' => route('of.courses.evaluation_quiz', [$course]), 'selected' => $selected === 'evaluation_quiz'];
        } else {
            $tab_nav[] = (object)['id' => 'module-quiz-tab', 'title' => 'Gestion module', 'route' => route('of.courses.elearning_selection', [$course]), 'selected' => $selected === 'elearning_scorm' || $selected === 'elearning_quiz' || $selected === 'elearning_selection'];
        }

        if ($course->description->intra === 1) {
            $tab_nav[] = (object)[
                'id' => 'intra-tab',
                'route' => route('of.courses.intras', [$course]),
                'title' => trans('of.intra_trainings.title'),
                'selected' => $selected === 'intras'];
        }

        $tab_nav[] = (object)[
            'id' => 'supports-tab',
            'route' => route('of.courses.supports', [$course]),
            'title' => trans('of.supports.title'),
            'selected' => $selected === 'supports'];

        $tab_nav[] = (object)[
            'id' => 'access-rules-tab',
            'route' => route('of.courses.access_rules', [$course]),
            'title' => trans('of.courses.access_rules.title'),
            'selected' => $selected === 'access-rules'];

        return $tab_nav;
    }
}
