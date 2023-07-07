<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
            $user_request->rules()
        );

    }

}
