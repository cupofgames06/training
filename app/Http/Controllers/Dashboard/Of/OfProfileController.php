<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\OfProfileRequest;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class OfProfileController extends OfController
{

    public function edit($locale): Response
    {
        return response()->view('dashboard.pages.of.profile-edit');
    }

    public function update(OfProfileRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['address']['country_id'] = Country::where('code', $datas['address']['country_iso'])->first()->id;
        unset($datas['address']['country_iso']);

        $this->of->update($datas['of']);
        $this->of->entity->update($datas['entity']);
        $this->of->address->update($datas['address']);
        $this->of->contact->update($datas['contact']);

        //Vérif : delete tampon
        if (!empty($datas['delete']['tampon'])) {

            $this->of->clearMediaCollection('tampon');
            $this->of->clearMediaCollection('tmp_tampon');

        } else {
            //Vérif upload tampon, suppression tmp le cas échéant
            $tmp_tampon = $this->of->getMedia('tmp_tampon')->first();
            if (!empty($tmp_tampon)) {
                $this->of->copyMedia($tmp_tampon->getPath())->toMediaCollection('tampon');
                $this->of->clearMediaCollection('tmp_tampon');
            }
        }

        if (!empty($datas['delete']['signature'])) {

            $this->of->clearMediaCollection('signature');
            $this->of->clearMediaCollection('tmp_signature');

        } else {

            //Vérif upload signature, suppression tmp le cas échéant
            $tmp_signature = $this->of->getMedia('tmp_signature')->first();
            if (!empty($tmp_signature)) {
                $this->of->clearMediaCollection('signature');
                $this->of->copyMedia($tmp_signature->getPath())->toMediaCollection('signature');
                $this->of->clearMediaCollection('tmp_signature');
            }
        }

        return  response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function destroy($id)
    {

    }

    public function upload_signature(): void
    {

        if (request()->hasFile('signature') && request()->file('signature')->isValid()) {
            $this->of->clearMediaCollection('tmp_signature');
            $this->of->addMediaFromRequest('signature')->toMediaCollection('tmp_signature');
        }
    }

    public function upload_tampon(): void
    {
        if (request()->hasFile('tampon') && request()->file('tampon')->isValid()) {
            $this->of->clearMediaCollection('tmp_tampon');
            $this->of->addMediaFromRequest('tampon')->toMediaCollection('tmp_tampon');
        }
    }
}
