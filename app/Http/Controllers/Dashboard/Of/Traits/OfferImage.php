<?php

namespace App\Http\Controllers\Dashboard\Of\Traits;

use Illuminate\Support\Facades\Auth;

trait OfferImage
{
    public function upload_image()
    {
        $name = 'offer_image';
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $user = Auth::user();
            $user->clearMediaCollection('tmp');
            $user->addMediaFromRequest($name)->usingName($name)->toMediaCollection('tmp');
        }
    }

}
