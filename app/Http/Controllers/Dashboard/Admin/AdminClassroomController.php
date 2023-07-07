<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Dashboard\AdminController;
use Illuminate\Http\Request;
use App\Core\DataTableAPI;
use App\Http\Requests\ClassroomRequest;
use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use App\Models\Country;
use App\View\Components\DataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminClassroomController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new DataTableAPI(Classroom::where(['of_id' => $this->of->id])->where('status','!=','deleted')->get(), $request);

            $dataTable->search(array(
                'search' => 'name',
            ));
            $dataTable->search(array(
                'search' => array(
                    'address.postal_code',
                    'address.city',
                    'name',
                    'max_learners',
                )
            ));
            $dataTable->ordering(array(
                0 => 'name',
                1 => 'address.postal_code',
                2 => 'address.city',
                3 => 'max_learners',
            ));

            return $dataTable->result(ClassroomResource::class);
        }
        $table = new DataTable();
        $table->columns(array(
            array(
                'title' => 'Nom',
                'class' => '',
            ),
            array(
                'title' => 'Code Postal',
                'class' => '',
            ),
            array(
                'title' => 'Ville',
                'class' => '',
            ),
            array(
                'title' => 'Places max',
                'class' => '',
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
        $table->action(array(
            'class' => 'btn btn-secondary',
            'label' => 'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('of.classrooms.create'),
        ));

        return view('dashboard.pages.of.classrooms', ['table' => $table->render()->with($table->data())]);
    }

    public function create(): Response
    {
        return response()->view('dashboard.pages.of.classroom-create');
    }

    public function store(ClassroomRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        $datas['address']['country_id'] = Country::where('code', $datas['address']['country_iso'])->first()->id;
        $datas['classroom']['of_id'] = $this->of->id;
        $classroom = Classroom::create($datas['classroom']);

        $classroom->address()->create($datas['address']);

        return response()->json(['redirect' => route('of.classrooms.edit', [$classroom]), 'success' => 'Création salle de formation effectuée']);
    }

    public function edit($locale, $id)
    {

        //todo : ajouter middleware, ou autre... pour vérif droits
        $classroom = Classroom::findOrFail($id);
        return response()->view('dashboard.pages.of.classroom-edit', [
            'classroom' => $classroom
        ]);
    }

    public function update(ClassroomRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['address']['country_id'] = Country::where('code', $datas['address']['country_iso'])->first()->id;
        unset($datas['address']['country_iso']);
        //todo : ajouter middleware, ou autre... pour vérif droits
        $classroom = Classroom::find($id);
        $classroom->update($datas['classroom']);
        $classroom->address->update($datas['address']);

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function destroy($locale, $id)
    {
        //todo vérifier autorisation
        $classroom = Classroom::find($id);
        $classroom->status = 'deleted';
        $classroom->save();

        return response()->json(['redirect' => route('of.classrooms.index'), 'success' => 'Suppression salle de formation effectuée']);
    }

}
