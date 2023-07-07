<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Requests\TrainerRequest;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\TrainerResource;
use App\Models\ModelHasUser;
use App\Models\Trainer;
use App\Models\User;
use App\View\Components\DataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

//todo : check permissions :
// pour l'of, le groupe ou la société en cours
// lui-même ou pas (modifs mot de passe et choix communications que pour soi-même > RGPD)

class AdminTrainerController extends AdminController
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|array|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->ajax()) {

            $dataTable = new DataTableAPI($this->of->trainers, $request);
            $dataTable->search(array(
                'search' => 'profile.full_name',
            ));

            $dataTable->ordering(array(
                0 => 'profile.full_name',
                1 => 'address.city',
            ));

            return $dataTable->result(TrainerResource::class);
        }

        $table = new DataTable();
        $table->columns(array(
            array(
                'title' => 'Nom Prénom',
                'class' => '',
            ),
            array(
                'title' => 'Ville',
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
            'route' => route('of.trainers.create'),
        ));

        return view('dashboard.pages.of.trainers', ['table' => $table->render()->with($table->data())]);
    }

    public function create(): Response
    {
        return response()->view('dashboard.pages.of.trainer-create');
    }

    public function store(TrainerRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        $trainer = Trainer::create($datas['user']);
        $trainer->save();
        $trainer->assignRole('trainer');
        $trainer->profile()->create($datas['profile']);
        $trainer->address()->create($datas['address']);
        $trainer->description()->create($datas['description']);
        if ($datas['description']['is_person'] != 1) {
            $trainer->entity()->create($datas['entity']);
        }

        $this->of->addUser($trainer->id);

        //Vérif upload, suppression tmp le cas échéant
        $tmp = Auth::user()->getMedia('tmp')->where('name', 'trainer_signature')->first();
        if (!empty($tmp)) {
            $trainer->copyMedia($tmp->getPath())->usingName($trainer->id)->toMediaCollection('signature');
        }
        Auth::user()->clearMediaCollection('tmp');

        return response()->json(['redirect' => route('of.trainers.edit', [$trainer]), 'success' => 'Création formateur effectuée']);
    }

    public function edit($locale, $id): Response
    {
        //todo : ajouter middleware, ou autre... pour vérif droits
        $trainer = Trainer::find($id);
        return response()->view('dashboard.pages.of.trainer-edit', [
            'trainer' => $trainer
        ]);
    }

    public function update(TrainerRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        $trainer = Trainer::find($id);
        $trainer->update($datas['user']);
        $trainer->profile->update($datas['profile']);
        $trainer->address->update($datas['address']);
        $trainer->description->update($datas['description']);
        if ($datas['description']['is_person'] == 0) {
            if (!empty($trainer->entity)) {
                $trainer->entity()->update($datas['entity']);
            } else {
                $trainer->entity()->create($datas['entity']);
            }

        } else {
            $trainer->entity()->delete();
        }

        //Vérif : delete image
        if (!empty($datas['delete']['image'])) {

            $trainer->clearMediaCollection('image');

        } else {
            $tmp = Auth::user()->getMedia('tmp')->where('name', 'trainer_signature_' . $trainer->id)->first();
            if (!empty($tmp)) {
                $trainer->clearMediaCollection('signature');
                $trainer->copyMedia($tmp->getPath())->usingName($trainer->reference)->toMediaCollection('signature');
            }

            Auth::user()->clearMediaCollection('tmp');
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function upload_signature(): void
    {
        $name = !empty(request()->get('id')) ? 'trainer_signature_' . request()->get('id') : 'trainer_signature';
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $user = Auth::user();
            $user->clearMediaCollection('tmp');
            $user->addMediaFromRequest($name)->usingName($name)->toMediaCollection('tmp');
        }
    }

    public function destroy($locale, $id)
    {
        $this->of->removeUser($id);
        return response()->json(['redirect' => route('of.trainers.index'), 'success' => 'Formateur retiré']);
    }

}
