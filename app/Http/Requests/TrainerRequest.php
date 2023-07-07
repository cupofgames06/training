<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRequest extends FormRequest
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
        $user_request = new UserRequest();

        return array_merge(
            $profile_request->rules(),
            $user_request->rules('trainer'),
            [
                'address.city' => 'required',
                'profile.birth_zipcode' => 'required',
                'profile.birth_date' => 'required',
                'profile.birth_country_id' => 'required'
            ]
        );

    }

}
