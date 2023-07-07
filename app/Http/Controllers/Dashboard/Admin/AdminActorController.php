<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Casts\Status;
use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Admin\Traits\IntraTrainings;
use App\Http\Controllers\Dashboard\Admin\Traits\Supports;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Requests\DayRequest;
use App\Http\Requests\PriceRequest;
use App\Http\Requests\SessionRequest;
use App\Http\Requests\SupportRequest;
use App\Http\Requests\SessionTrainerRequest;
use App\Http\Resources\SessionResource;
use App\Models\Course;
use App\Models\IntraTraining;
use App\Models\Session;
use App\Models\SessionDay;
use App\Models\Support;
use App\Models\SessionTrainer;
use App\View\Components\DataTable;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionClass;

//todo : check permissions :
// pour l'of, le groupe ou la société en cours
// lui-même ou pas (modifs mot de passe et choix communications que pour soi-même > RGPD)

class AdminActorController extends AdminController
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $dataTable = new DataTableAPI(Session::with('course','description','course.description')->whereNotIn('status',[Status::DELETED])->get(),$request);

            $dataTable->search(array(
                'search' => array(
                    'date_start',
                    'course.description.name',
                    'course.description.reference',
                    'place',
                    'status'
                )
            ));

            $dataTable->ordering(array(
                0 => 'date_start',
                1 => 'course.description.reference',
                2 => 'course.description.name',
                3 => 'place',
                4 => 'status',
                5 => ''
            ));

            return $dataTable->result(SessionResource::class);
        }
        $table = new DataTable();
        $table->columns(array(
            array(
                'title' => 'Début formation',
                'class' => '',
            ),
            array(
                'title' => 'Référence',
                'class' => '',
            ),
            array(
                'title' => 'Intitulé',
                'class' => '',
            ),
            array(
                'title' => 'Ville',
                'class' => '',
            ),
            array(
                'title' => 'Status',
                'class' => '',
            ),
            array(
                'title' => 'Inscrits / Places',
                'class' => '',
            ),
            array(
                'title' => 'Détails',
                'name' => 'detail',
                'orderable'=> false,
                'class' => 'dt-right'
            )
        ));
        $table->ajax();
        $table->search(true);

        $table->action(array(
            'class'=>'btn btn-secondary',
            'label' =>'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('of.sessions.create'),
        ));

        return view('dashboard.pages.of.sessions',['table'=> $table->render()->with($table->data()) ]);
    }

    public function create(): Response
    {
        return response()->view('dashboard.pages.of.session-create');
    }

    public function store(SessionRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $session = Session::create($datas['session']);
        $session->status = 'inactive';
        $session->save();
        $session->description()->create($datas['description']);

        return response()->json(['redirect' => route('of.sessions.edit', [$session]), 'success' => 'Création session effectuée']);
    }

    public function edit($locale, $id)
    {

        $session = Session::find($id);
        $tab_nav = $this->_navtab($session, 'info');
        return response()->view('dashboard.pages.of.session-edit', compact('session', 'tab_nav'));
    }

    public function update(SessionRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $session = Session::find($id);

        $redirect = $session->course_id != $datas['session']['course_id'] || $session->description->intra != $datas['description']['intra'];

        $session->update($datas['session']);
        $session->description()->update($datas['description']);
        return $redirect ? response()->json(['redirect' => route('of.sessions.edit', [$session]), 'success' => 'Mise à jour session effectuée']) : response()->json(['success' => 'Mise à jour session effectuée']);

    }

    public function toggle_status($locale, $pack, $status): JsonResponse
    {
        $item = Session::find($pack);
        $item->update(['status'=>$status]);
        return response()->json(['reload' => true, 'success' => $status == 'active'?'Mise en ligne effectuée':'Retrait effectué']);
    }

    public function destroy($locale, $id)
    {
        $item = Session::find($id);
        $item->status = 'deleted';
        $item->save();

        return response()->json(['redirect' => route('of.sessions.index'), 'success' => 'Suppression session effectuée']);
    }

    public function intras($locale, $id)
    {
        $item = Session::find($id);
        $c = new ReflectionClass($item);
        $tab_nav = $this->_navtab($item, 'intras');
        $breadcrumbs = [
            route('of.sessions.index') => trans('of.sessions.index.title'),
            route('of.sessions.edit', ['session' => $item]) => trans('of.sessions.edit.title'),
            '#' => trans('of.intra_trainings.title')
        ];

        return response()->view('dashboard.pages.of.intra-trainings', [
            'title'=>$item->title(),
            'subtitle'=>$item->subtitle(),
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
        $item = Session::find($id);
        $tab_nav = $this->_navtab($item, 'supports');
        $breadcrumbs = [
            route('of.sessions.index') => trans('of.sessions.index.title'),
            route('of.sessions.edit', ['session' => $item]) => trans('of.sessions.edit.title'),
            '#' => trans('of.supports.title')
        ];

        $c = new ReflectionClass($item);
        return response()->view('dashboard.pages.of.supports', [
            'title'=>$item->title(),
            'subtitle'=>$item->subtitle(),
            'item' => $item,
            'item_type' => $c->getShortName(),
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }


    public function days($locale, $id)
    {
        $item = Session::with('days')->find($id);

        $tab_nav = $this->_navtab($item, 'days');

        return response()->view('dashboard.pages.of.session-days', [
            'item' => $item,
            'tab_nav' => $tab_nav
        ]);
    }

    public function store_day(DayRequest $request, $locale, $item_id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['day']['date'] = Carbon::createFromFormat(custom('date_format'), $datas['day']['date']);

        $item = Session::find($item_id);
        $item->days()->create($datas['day']);

        return response()->json(['redirect' => route('of.sessions.days', [$item_id]), 'success' => 'Création effectuée']);
    }

    public function update_day(DayRequest $request, $locale, $day_id)
    {
        $datas = $request->except('_token', '_method');
        $datas['day']['date'] = Carbon::createFromFormat(custom('date_format'), $datas['day']['date'])->format('Y-m-d');

        $item = SessionDay::find($day_id);
        $return['success'] = trans('common.updated');
        if (!empty($datas['day'])) {
            if ($item->date->format('Y-m-d') != $datas['day']['date']) {
                $return['redirect'] = route('of.sessions.days', [$item->session_id]);
            }

            $item->update($datas['day']);
        }

        return response()->json($return);
    }

    public function delete_day($locale, $item_id, $day_id): JsonResponse
    {
        $item = Session::find($item_id);
        $item->days()->where('id', $day_id)->delete();

        return response()->json(['redirect' => route('of.sessions.days', [$item]), 'success' => 'Suppression effectuée']);
    }

    public function trainers($locale, $id)
    {
        $item = Session::find($id);
        $tab_nav = $this->_navtab($item, 'trainers');

        return response()->view('dashboard.pages.of.session-trainers', [
            'item' => $item,
            'tab_nav' => $tab_nav
        ]);
    }

    public function store_trainer(SessionTrainerRequest $request, $locale, $item_id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $item = Session::find($item_id);
        $datas['session_trainer']['session_id'] = $item_id;
        SessionTrainer::create($datas['session_trainer']);

        return response()->json(['redirect' => route('of.sessions.trainers', [$item_id]), 'success' => 'Création effectuée']);
    }

    public function update_trainer($locale, $item, $trainer_session_id)
    {
        $datas = request()->except('_token', '_method');
        $item = SessionTrainer::find($trainer_session_id);
        if (!empty($datas['session_trainer'])) {
            $item->update($datas['session_trainer']);
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function delete_trainer($locale, $item_id, $session_trainer_id): JsonResponse
    {
        SessionTrainer::find($session_trainer_id)->delete();
        return response()->json(['redirect' => route('of.sessions.trainers', [$item_id]), 'success' => 'Suppression effectuée']);
    }

    //Retourn pour ajax > show/hide choix classroom, ...
    public function get_course(): JsonResponse
    {
        $datas = request()->except('_token', '_method');
        $course_id = $datas['course_id'];
        return response()->json(Course::find($course_id)->toArray());
    }

    private function _navtab($session, $selected = ''): array
    {
        $tab_nav = [
            (object)['id' => 'info-tab', 'title' => 'Informations', 'route' => route('of.sessions.edit', [$session]), 'selected' => $selected === 'info']
        ];

        $tab_nav[] = (object)[
            'id' => 'days-tab',
            'route' => route('of.sessions.days', [$session]),
            'title' => trans('of.session_days.title'),
            'selected' => $selected === 'days'];

        $tab_nav[] = (object)[
            'id' => 'trainers-tab',
            'route' => route('of.sessions.trainers', [$session]),
            'title' => trans('of.session_trainers.title'),
            'selected' => $selected === 'trainers'];

        if ($session->description->intra === 1) {
            $tab_nav[] = (object)[
                'id' => 'intra-tab',
                'route' => route('of.sessions.intras', [$session]),
                'title' => trans('of.intra_trainings.title'),
                'selected' => $selected === 'intras'];
        }

        $tab_nav[] = (object)[
            'id' => 'supports-tab',
            'route' => route('of.sessions.supports', [$session]),
            'title' => trans('of.supports.title'),
            'selected' => $selected === 'supports'];


        return $tab_nav;
    }
}
