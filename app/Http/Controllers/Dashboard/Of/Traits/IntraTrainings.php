<?php

namespace App\Http\Controllers\Dashboard\Of\Traits;

use App\Models\IntraTraining;

trait IntraTrainings
{
    public function validate_intra($datas, $item, $intra_training_id = null): ?\Illuminate\Http\JsonResponse
    {
        $response = null;

        if (empty($datas['intra_training']['companies'])) {

            $doublon = IntraTraining::where([
                'trainable_id' => $item->id,
                'trainable_type' => $item::class
            ])->where('companies', null)->where('id', '!=', $intra_training_id)->count();

            if ($doublon > 0) {
                $response = response()->json(['alert' => 'Cette '.$item::class.' possède déjà un tarif intra par défaut'])->setStatusCode(422);
            }

        } else {

            $doublon = IntraTraining::where([
                'trainable_id' => $item->id,
                'trainable_type' => $item::class,
            ])->where('id', '!=', $intra_training_id)->where(function ($query) use ($datas) {

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

    public function create_intra($item,$request): void
    {
        $datas = $request->except('_token', '_method');

        //todo : méthode auto ? souhaitable si déport Trait commun session/course
        $datas['intra_training']['trainable_id'] = $item->id;
        $datas['intra_training']['trainable_type'] = $item::class;
        $intra_training = new IntraTraining($datas['intra_training']);
        $intra_training->save();

        $item->intra_trainings()->save($intra_training);
        $intra_training->setPrices($datas['price']);
    }

    public function set_intra($intra_id, $datas): void
    {
        $intra_training = IntraTraining::find($intra_id);
        if (!empty($datas['intra_training'])) {
            $intra_training->update($datas['intra_training']);
        }

        $intra_training->setPrices($datas['price']);
    }

}
