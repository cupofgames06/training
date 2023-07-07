<?php

namespace App\Http\Requests;

use App\Models\Trainer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class TrainerProfileRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $profile_request = new ProfileRequest();
        $id = null;

        if (Cache::has('account')) {
            $id = Cache::get('account')->id;
        }

        return array_merge(
            $profile_request->rules(),
            [
                'user.email' => ['email', 'max:255', 'unique:users,email,' . $id],
                'user.password' => ['nullable', 'min:8'],
                'address.city' => 'required',
                'profile.birth_zipcode' => 'required',
                'profile.birth_date' => 'required',
                'profile.birth_country_id' => 'required'
            ]
        );

    }

}
