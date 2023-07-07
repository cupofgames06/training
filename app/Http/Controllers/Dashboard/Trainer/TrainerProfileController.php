<?php

namespace App\Http\Controllers\Dashboard\Trainer;

use App\Http\Controllers\Dashboard\TrainerController;
use App\Http\Requests\TrainerProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TrainerProfileController extends TrainerController
{
    public function edit($locale): Response
    {
        return response()->view('dashboard.pages.trainer.profile-edit', [
            'trainer' => $this->trainer
        ]);
    }

    public function update(TrainerProfileRequest $request, $locale): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        $this->trainer->update($datas['user']);
        $this->trainer->profile->update($datas['profile']);
        $this->trainer->address->update($datas['address']);
        $this->trainer->description->update($datas['description']);
        if ($datas['description']['is_person'] == 0) {
            if (!empty($this->trainer->entity)) {
                $this->trainer->entity()->update($datas['entity']);
            } else {
                $this->trainer->entity()->create($datas['entity']);
            }

        } else {
            $this->trainer->entity()->delete();
        }

        //Vérif : delete image
        if (!empty($datas['delete']['image'])) {
            $this->trainer->clearMediaCollection('signature');
        } else {
            $tmp = Auth::user()->getMedia('tmp')->where('name', 'trainer_signature')->first();
            if (!empty($tmp)) {
                $this->trainer->clearMediaCollection('signature');
                $this->trainer->copyMedia($tmp->getPath())->usingName($tmp->file_name)->toMediaCollection('signature');
            }

            Auth::user()->clearMediaCollection('tmp');
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function upload_signature(): void
    {
        $name = 'trainer_signature';
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $user = Auth::user();
            $user->clearMediaCollection('tmp');
            $user->addMediaFromRequest($name)->usingName($name)->toMediaCollection('tmp');
        }
    }

}
