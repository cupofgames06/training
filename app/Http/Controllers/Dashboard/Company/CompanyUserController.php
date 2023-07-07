<?php

namespace App\Http\Controllers\Dashboard\Company;

use App\Core\Datatable\Table;
use App\Core\DataTableAPI;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Requests\ManagerRequest;
use App\Http\Resources\CompanyUserResource;
use App\Http\Resources\OfUserResource;
use App\Models\User;
use App\View\Components\DataTable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class CompanyUserController extends CompanyController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View|array|Application
     */
    public function index(Request $request): Factory|View|array|Application
    {
        if ($request->ajax()) {
            $users = $this->company->managers;
            $dataTable = new DataTableAPI($users, $request);
            $dataTable->search(array(
                'search' => 'profile.full_name,email'
            ));

            $dataTable->ordering(array(
                0 => 'profile.full_name',
                1 => 'email'
            ));

            return $dataTable->result(CompanyUserResource::class);
        }

        $table = new Table();

        // ajouter les colonnes de la datatables
        $table->columns(array(
            array(
                'title' => trans('common.profile.last_name'),
                'class' => ''
            ),
            array(
                'title' => trans('common.user.email'),
                'class' => ''
            ),
            array(
                'title' => trans('common.details'),
                'name' => 'detail',
                'class' => 'dt-right'
            )
        ));

        $table->ajax();
        $table->search(true);

        $table->action(array(
            'class' => 'btn btn-secondary',
            'label' => trans('common.add'),
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('company.users.create'),
        ));

        return view('dashboard.partials.users', ['table' => $table]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('dashboard.pages.company.user-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerRequest $request
     * @param $locale
     * @return JsonResponse
     */
    public function store(ManagerRequest $request, $locale)
    {
        $datas = $request->except('_token', '_method');
        $user = User::create($datas['user']);
        $user->profile()->create($datas['profile']);

        $user->assignRole('Company');
        $this->company->addUser($user->id);

        //todo: email invitation choix mot de passe

        return response()->json(['redirect' => route('company.users.edit', [$user]), 'success' => 'Création effectuée']);
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
        return response()->view('dashboard.pages.company.user-edit', [
            'user' => User::find($id)
        ]);
    }

    public function update(ManagerRequest $request, $locale, $id)
    {
        $datas = $request->except('_token', '_method');

        $user = User::find($id);
        if (empty($datas['user']['password'])) { //laissez vide pour conserver votre mdp
            unset($datas['user']['password']);
        } else {
            $datas['user']['password'] = Hash::make($datas['user']['password']);
        }
        $user->update($datas['user']);
        $user->profile->update($datas['profile']);

        return response()->json(['success' => 'mise à jour effectuée']);
    }

    public function delete($locale, $id)
    {
        $this->company->removeUser($id);
        return response()->json(['redirect' => route('company.users.index'), 'success' => 'Administrateur supprimé']);
    }
}
