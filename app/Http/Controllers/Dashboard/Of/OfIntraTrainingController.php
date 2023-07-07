<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\PriceRequest;
use App\Models\IntraTraining;
use Illuminate\Http\JsonResponse;


class OfIntraTrainingController extends OfController
{
    public function store(PriceRequest $request, $locale, $item_type, $item_id): JsonResponse
    {
        $model = "App\Models\\" . ucfirst($item_type);
        $model = new $model;
        $item = $model::find($item_id);

        $datas = $request->except('_token', '_method');
        $doublon = $this->_validate_intra($datas, $item);
        if ($doublon != null) {
            return $doublon;
        }

        $intra_training = new IntraTraining($datas['intra_training']);
        $item->intra_trainings()->save($intra_training);
        $intra_training->setPrices($datas['price']);

        return response()->json(['reload' => true, 'success' => 'Création effectuée']);
    }

    public function update(PriceRequest $request, $locale,  $intra_id)
    {
        $datas = $request->except('_token', '_method');

        $intra = IntraTraining::find($intra_id);

        //todo : mieux faire avec un équivalent getModel?
        $model = new $intra->trainable_type;
        $item = $model::find($intra->trainable_id);
        $doublon = $this->_validate_intra($datas, $item, $intra_id);
        if ($doublon != null) {
            return $doublon;
        }

        $intra_training = IntraTraining::find($intra_id);
        if (!empty($datas['intra_training'])) {
            $intra_training->update($datas['intra_training']);
        }

        $intra_training->setPrices($datas['price']);

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function delete($locale, $intra_id): JsonResponse
    {
        IntraTraining::where('id', $intra_id)->delete();
        return response()->json(['reload' => true, 'success' => 'Suppression effectuée']);
    }

    private function _validate_intra($datas, $item, $intra_training_id = null): ?\Illuminate\Http\JsonResponse
    {
        $response = null;

        if (empty($datas['intra_training']['companies'])) {

            $doublon = $item->intra_trainings()->where('companies', null)->where('id', '!=', $intra_training_id)->count();

            if ($doublon > 0) {
                $response = response()->json(['alert' => 'Cette élément possède déjà un tarif intra par défaut'])->setStatusCode(422);
            }

        } else {

            $doublon = $item->intra_trainings()->where('id', '!=', $intra_training_id)->where(function ($query) use ($datas) {

                foreach ($datas['intra_training']['companies'] as $company) {
                    $query->orWhereJsonContains('companies', $company);
                }

            })->count();

            if ($doublon > 0) {
                $response = response()->json(['alert' => 'Une ou plusieurs sociétés sélectionnée(s) possède(nt) déjà un tarif'])->setStatusCode(422);
            }
        }

        return $response;
    }

}
