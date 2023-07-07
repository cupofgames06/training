<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\PriceRequest;
use App\Models\IntraTraining;
use App\Models\ModelAccessRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class OfAccessRuleController extends OfController
{
    public function store(PriceRequest $request, $locale, $item_type, $item_id): JsonResponse
    {
        $model = "App\Models\\" . ucfirst($item_type);
        $model = new $model;
        $item = $model::find($item_id);

        $datas = $request->except('_token', '_method');
        $formRequest = new AccessRuleRequest();
        $validator = Validator::make($datas, $formRequest->rules());
        $json = $datas['access_rules']['rule'];
        $doublon = $item->access_rules()->whereJsonContains('rule', $json)->count();
        if ($doublon > 0 && $validator->passes()) {
            return response()->json(['alert' => 'Cette règle existe déjà pour cette formation'])->setStatusCode(422);
        } elseif (!$validator->passes()) {
            return response()->json(['alert' => 'Spécifiez au moins une obligation'])->setStatusCode(422);
        }


        $access_rule = new ModelAccessRule($datas['access_rules']);
        $item->access_rules()->save($access_rule);

        return response()->json(['reload' => true, 'success' => 'Création effectuée']);
    }

    public function update(PriceRequest $request, $locale, $access_rule_id)
    {
        $datas = $request->except('_token', '_method');

        $access_rule = ModelAccessRule::find($access_rule_id);

        //todo : mieux faire avec un équivalent getModel?
        $model = new $access_rule->model_type;
        $item = $model::find($access_rule->model_id);

        $formRequest = new AccessRuleRequest();
        $validator = Validator::make($datas, $formRequest->rules());
        $json = $datas['access_rules']['rule'];
        $doublon = $item->access_rules()->whereJsonContains('rule', $json)->count();
        if ($doublon > 1 && $validator->passes()) {
            return response()->json(['alert' => 'Cette règle existe déjà pour cette formation'])->setStatusCode(422);
        } elseif (!$validator->passes()) {
            return response()->json(['alert' => 'Spécifiez au moins une obligation'])->setStatusCode(422);
        }

        $access_rule->update($datas['access_rules']);

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function delete($locale, $access_rule_id): JsonResponse
    {
        ModelAccessRule::where('id', $access_rule_id)->delete();
        return response()->json(['reload' => true, 'success' => 'Suppression effectuée']);
    }


}
