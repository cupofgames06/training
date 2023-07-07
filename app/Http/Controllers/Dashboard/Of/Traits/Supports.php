<?php

namespace App\Http\Controllers\Dashboard\Of\Traits;

use App\Http\Requests\SupportRequest;
use App\Models\Course;
use App\Models\IntraTraining;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;

trait Supports
{
    public function upload_support_document()
    {
        $name = !empty(request()->get('id')) ? 'support_document_' . request()->get('id') : 'support_document';
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $user = Auth::user();
            $user->clearMediaCollection('tmp');
            $user->addMediaFromRequest($name)->usingName($name)->toMediaCollection('tmp');
        }
    }

    public function create_support($item,$datas){
        $tmp = Auth::user()->getMedia('tmp')->where('name', 'support_document')->first();
        if (empty($tmp)) {
            return response()->json(['alert' => 'Vous n\'avez téléchargé aucun document'])->setStatusCode(422);
        }

        $datas['support']['supportable_id'] = $item->id;
        $datas['support']['supportable_type'] = $item::class;

        $support = $item->supports()->create($datas['support']);
        $support->copyMedia($tmp->getPath())->usingName($support->name)->toMediaCollection('documents');
        Auth::user()->clearMediaCollection('tmp');
    }


    public function update_support(SupportRequest $request, $locale, $support_id)
    {
        $datas = $request->except('_token', '_method');
        $item = Support::find($support_id);
        if (!empty($datas['support'])) {
            $item->update($datas['support']);
        }

        if (!empty($datas['delete']['support_document_' . $support_id])) {
            $item->clearMediaCollection('documents');
        } else {
            //Vérif upload image, suppression tmp le cas échéant
            $tmp = Auth::user()->getMedia('tmp')->where('name', 'support_document_' . $support_id)->first();
            if (!empty($tmp)) {
                $item->clearMediaCollection('documents');
                $item->copyMedia($tmp->getPath())->toMediaCollection('documents');
            }
        }

        Auth::user()->clearMediaCollection('tmp');

        return response()->json(['success' => 'Mise à jour effectuée']);
    }


}
