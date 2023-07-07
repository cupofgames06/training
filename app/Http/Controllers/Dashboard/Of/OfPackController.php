<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Casts\Status;
use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Dashboard\Of\Traits\OfferImage;
use App\Http\Controllers\Dashboard\Of\Traits\Quizzes;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\PackRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\PackResource;
use App\Models\Course;
use App\Models\Pack;
use App\Models\Packable;
use App\Models\QuizVersion;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use ReflectionClass;

class OfPackController extends OfController
{
    use Quizzes;
    use OfferImage;

    public string $type = 'pack';
    public function __construct()
    {

        $this->type = substr(request()->segment(4), 0, -1);
        View::share('pack_type',$this->type);

        parent::__construct();
    }

    public function index(Request $request)
    {


        if ($request->ajax()) {
            $packs = Pack::where('type', $this->type)->with('description')->whereNotIn('status',[Status::DELETED])->get();
            $dataTable = new DataTableAPI($packs, $request);

            $dataTable->search(array(
                'search' => 'description.reference',
            ));

            $dataTable->ordering(array(
                0 => 'description.reference',
                1 => 'description.name',
            ));

            return $dataTable->result(PackResource::class);
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
                'title' => 'Détail',
                'class' => 'dt-right'
            )
        ));

        $table->search(true);

        $table->filters(array(
            array(
                'label' => 'Status',
                'items' => array('1', "2"),
            ),
        ));

        $table->ajax();

        $table->action(array(
            'class' => 'btn btn-secondary',
            'label' => 'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('of.'.$this->type.'s.create'),
        ));

        $tab_nav = courses_tab($this->type.'s');

        return view('dashboard.pages.of.packs', compact('table', 'tab_nav'));
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

        return response()->view('dashboard.pages.of.pack-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param $locale
     * @return JsonResponse
     */
    public function store(PackRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['pack']['of_id'] = Auth::user()->ofs()->first()->id; //todo : of en cours
        $pack = Pack::create($datas['pack']);
        $pack->status = 'inactive';
        $pack->save();
        $pack->description()->create($datas['description']);
        if ($datas['description']['intra'] == 0) {
            $pack->setPrices($datas['price']);
        }
        $pack->storeImage();

        return response()->json(['redirect' => route('of.'.$this->type.'s.edit', [$pack]), 'success' => 'Création formation effectuée']);
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

        $pack = Pack::find($id);
        $tab_nav = $this->_navtab($pack, 'info');
        return response()->view('dashboard.pages.of.pack-edit', [
            'pack' => $pack,
            'tab_nav' => $tab_nav
        ]);
    }

    public function update(PackRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $pack = Pack::find($id);

        //redirection suite à update, si modification d'un champs ci-dessous
        $redirect = $pack->type != $datas['pack']['type']
            || $pack->description->intra != $datas['description']['intra']
            || $pack->description->reference != $datas['description']['reference']
            || $pack->description->name != $datas['description']['name'][app()->getLocale()]
            || $pack->description->pre_requisite_quiz != $datas['description']['pre_requisite_quiz'];

        $pack->update($datas['pack']);
        $pack->description()->update($datas['description']);

        if ($datas['description']['intra'] == 0) {
            $pack->setPrices($datas['price']);
        }

        if (!empty($datas['delete']['offer_image'])) {
            $pack->description->clearMediaCollection('image');
        } else {
            $pack->updateImage();
        }

        return $redirect ? response()->json(['redirect' => route('of.'.$this->type.'s.edit', [$pack]), 'success' => 'Mise à jour formation effectuée']) : response()->json(['success' => 'Mise à jour formation effectuée']);
    }

    public function toggle_status($locale, $pack, $status): JsonResponse
    {
        $item = Pack::find($pack);

        $item->update(['status'=>$status]);
        return response()->json(['reload' => true, 'success' => $status == 'active'?'Mise en ligne effectuée':'Retrait effectué']);
    }

    public function destroy($locale, $id)
    {
        $item = Pack::find($id);
        $item->status = 'deleted';
        $item->save();

        return response()->json(['redirect' => route('of.packs.index'), 'success' => 'Suppression pack effectuée']);
    }

    public function intras($locale, $id)
    {
        $item = Pack::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'intras');
        $breadcrumbs = [
            route('of.packs.index') => trans('of.packs.index.title'),
            route('of.packs.edit', ['pack' => $item]) => trans('of.packs.edit.title'),
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
        $item = Pack::find($id);
        $tab_nav = $this->_navtab($item, 'supports');
        $breadcrumbs = [
            route('of.packs.index') => trans('of.packs.index.title'),
            route('of.packs.edit', ['pack' => $item]) => trans('of.packs.edit.title'),
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

    public function packables($locale, $id)
    {
        $pack = Pack::find($id);
        $tab_nav = $this->_navtab($pack, 'packables');
        $breadcrumbs = [
            route('of.'.$this->type.'s.index') => trans('of.'.$this->type.'s.index.title'),
            route('of.'.$this->type.'s.edit', ['pack' => $pack]) => trans('of.'.$this->type.'s.edit.title'),
            '#' => trans('of.'.$this->type.'s.packables.title')
        ];

        return response()->view('dashboard.pages.of.packables', [
            'pack' => $pack,
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }

    public function store_packable(Request $request, $locale, $pack_id): JsonResponse
    {

        $datas = $request->except('_token', '_method');
        $empty = empty($datas['elearning']) && empty($datas['session']);
        if ($empty) {
            return response()->json(['alert' => 'Spécifiez au moins un élément'])->setStatusCode(422);
        }

        if (!empty($datas['elearning'])) {
            foreach ($datas['elearning'] as $id) {
                $course = Course::find($id);
                $packable = new Packable(['pack_id' => $pack_id, 'position' => 1]);
                $course->packables()->save($packable);
            }
        }

        if (!empty($datas['session'])) {
            foreach ($datas['session'] as $id) {
                $session = Session::find($id);
                $packable = new Packable(['pack_id' => $pack_id, 'position' => 1]);
                $session->packables()->save($packable);
            }
        }

        return response()->json(['reload' => true, 'success' => 'Création effectuée']);
    }

    public function delete_packable($locale, $packable_id): JsonResponse
    {
        Packable::find($packable_id)->delete();
        return response()->json(['reload' => true, 'success' => 'Suppression effectuée']);
    }

    public function update_position(): void
    {
        $datas = request()->except('_token', '_method');
        $positions = $datas['position'];
        foreach ($positions as $v) {
            Packable::where('id', $v['id'])->update(['position' => $v['position']]);
        }

    }

    public function delete_session($locale, $packable_id): JsonResponse
    {
        Packable::where(['packable_type' => 'App\Models\Session', 'packable_id' => $packable_id])->delete();
        return response()->json(['reload' => true, 'success' => 'Suppression effectuée']);
    }

    public function pre_requisite_quiz($locale, $pack_id, $version_id = null, $page_id = null)
    {
        $item = Pack::find($pack_id);

        $breadcrumbs = [
            route('of.'.$this->type.'s.index') => trans('of.'.$this->type.'s.index.title'),
            route('of.'.$this->type.'s.edit', ['pack' => $item]) => trans('of.'.$this->type.'s.edit.title'),
            '#' => trans('of.courses.tab_nav.prerequisite-quiz'),
        ];

        $tab_nav = $this->_navtab($item, 'pre_requisite_quiz');
        $quiz = $item->getPreRequisiteQuiz();
        $version = empty($version_id) ? $quiz->versions->first() : QuizVersion::find($version_id);
        $page_id = empty($page_id) ? $version->pages->first()->id : $page_id;

        return $this->load_quiz($page_id, $breadcrumbs, $tab_nav, $item->description->reference, $item->description->name);
    }

    private function _navtab($pack, $selected = ''): array
    {
        $tab_nav = [
            (object)['id' => 'info-tab', 'title' => 'Informations', 'route' => route('of.'.$this->type.'s.edit', [$pack]), 'selected' => $selected === 'info']
        ];

        $tab_nav[] = (object)[
            'id' => 'packables-tab',
            'route' => route('of.'.$this->type.'s.packables', [$pack]),
            'title' => trans('of.'.$this->type.'s.packables.title'),
            'selected' => $selected === 'packables'];

        if ($pack->description->pre_requisite_quiz === 1) {
            $tab_nav[] = (object)['id' => 'pre-requisite-quiz-tab', 'title' => trans('of.courses.tab_nav.prerequisite-quiz'), 'route' => route('of.'.$this->type.'s.pre_requisite_quiz', [$pack]), 'selected' => $selected === 'pre_requisite_quiz'];
        }

        if ($pack->description->intra === 1) {
            $tab_nav[] = (object)[
                'id' => 'intra-tab',
                'route' => route('of.'.$this->type.'s.intras', [$pack]),
                'title' => trans('of.intra_trainings.title'),
                'selected' => $selected === 'intras'];
        }

        $tab_nav[] = (object)[
            'id' => 'supports-tab',
            'route' => route('of.'.$this->type.'s.supports', [$pack]),
            'title' => trans('of.supports.title'),
            'selected' => $selected === 'supports'];


        return $tab_nav;
    }
}
