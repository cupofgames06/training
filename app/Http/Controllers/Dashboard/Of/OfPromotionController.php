<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Http\Controllers\Dashboard\OfController;
use App\Models\Company;
use App\Models\Course;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Country;
use App\View\Components\DataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

//todo : check permissions :
// pour l'of, le groupe ou la société en cours
// lui-même ou pas (modifs mot de passe et choix communications que pour soi-même > RGPD)

class OfPromotionController extends OfController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new DataTableAPI(Promotion::all(), $request);

            $dataTable->search(array(
                'search' => ['name','amount']
            ));

            $dataTable->ordering(array(
                0 => 'name',
                1 => 'amount',
            ));

            return $dataTable->result(PromotionResource::class);
        }
        $table = new DataTable();
        $table->columns(array(
            array(
                'title' => 'Nom',
                'class' => '',
            ),
            array(
                'title' => 'Remise',
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
            'class' => 'btn btn-secondary',
            'label' => 'Ajouter',
            'icon' => '<i class="fa-regular fa-circle-plus"></i>',
            'route' => route('of.promotions.create'),
        ));

        return view('dashboard.pages.of.promotions', ['table' => $table->render()->with($table->data())]);
    }

    public function create(): Response
    {
        return response()->view('dashboard.pages.of.promotion-create');
    }

    public function store(PromotionRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['promotion']['date_start'] = Carbon::createFromFormat(custom('date_format'), $datas['promotion']['date_start']);
        $datas['promotion']['date_end'] = Carbon::createFromFormat(custom('date_format'), $datas['promotion']['date_end']);
        $promotion = Promotion::create($datas['promotion']);
        $promotion->save();

        if (!empty($datas['companies'])) {
            $promotion->setCompanies($datas['companies']);
        }

        return response()->json(['redirect' => route('of.promotions.edit', [$promotion]), 'success' => 'Création promotion effectuée']);
    }

    public function edit($locale, $id)
    {
        $promotion = Promotion::findOrFail($id);
        return response()->view('dashboard.pages.of.promotion-edit', [
            'promotion' => $promotion
        ]);
    }

    public function update(PromotionRequest $request, $locale, $id): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['promotion']['date_start'] = Carbon::createFromFormat(custom('date_format'), $datas['promotion']['date_start']);
        $datas['promotion']['date_end'] = Carbon::createFromFormat(custom('date_format'), $datas['promotion']['date_end']);
        $promotion = Promotion::find($id);
        $promotion->update($datas['promotion']);

        if (!empty($datas['companies'])) {
            $promotion->setCompanies($datas['companies']);
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function destroy($id)
    {

    }

}
