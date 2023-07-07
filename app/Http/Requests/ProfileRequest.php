<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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

    //regle de base validation profile (user, learner...)
    public function rules()
    {
        return [
            'profile.first_name' => ['required'],
            'profile.last_name' => ['required'],
        ];

    }

}
