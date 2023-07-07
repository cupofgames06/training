<?php

namespace App\Http\Controllers\Dashboard\Company;

use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Requests\CompanyProfileRequest;
use App\Http\Requests\OfProfileRequest;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyProfileController extends CompanyController
{

    public function edit($locale): Response
    {
        return response()->view('dashboard.pages.company.profile-edit');
    }

    public function update(CompanyProfileRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');
        $datas['address']['country_id'] = Country::where('code', $datas['address']['country_iso'])->first()->id;
        unset($datas['address']['country_iso']);

        $this->company->entity->update($datas['entity']);
        $this->company->address->update($datas['address']);
        $this->company->contact->update($datas['contact']);

        //Vérif : delete tampon
        if (!empty($datas['delete']['tampon'])) {

            $this->company->clearMediaCollection('tampon');
            $this->company->clearMediaCollection('tmp_tampon');

        } else {
            //Vérif upload tampon, suppression tmp le cas échéant
            $tmp_tampon = $this->company->getMedia('tmp_tampon')->first();
            if (!empty($tmp_tampon)) {
                $this->company->copyMedia($tmp_tampon->getPath())->toMediaCollection('tampon');
                $this->company->clearMediaCollection('tmp_tampon');
            }
        }

        if (!empty($datas['delete']['signature'])) {

            $this->company->clearMediaCollection('signature');
            $this->company->clearMediaCollection('tmp_signature');

        } else {

            //Vérif upload signature, suppression tmp le cas échéant
            $tmp_signature = $this->company->getMedia('tmp_signature')->first();
            if (!empty($tmp_signature)) {
                $this->company->clearMediaCollection('signature');
                $this->company->copyMedia($tmp_signature->getPath())->toMediaCollection('signature');
                $this->company->clearMediaCollection('tmp_signature');
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
            $this->company->clearMediaCollection('tmp_signature');
            $this->company->addMediaFromRequest('signature')->toMediaCollection('tmp_signature');
        }
    }

    public function upload_tampon(): void
    {
        if (request()->hasFile('tampon') && request()->file('tampon')->isValid()) {
            $this->company->clearMediaCollection('tmp_tampon');
            $this->company->addMediaFromRequest('tampon')->toMediaCollection('tmp_tampon');
        }
    }
}
