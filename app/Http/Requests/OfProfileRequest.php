<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfProfileRequest extends FormRequest
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
        return [
            'of.agreement_number' => ['required'],
            'entity.reg_number' => ['required'],
            'address.street_number' => ['required'],
            'address.street_name' => ['required'],
            'address.postal_code' => ['required'],
            'address.city' => ['required'],
            'address.country_iso' => ['required'],
            'contact.title' => ['required'],
            'contact.first_name' => ['required'],
            'contact.last_name' => ['required'],
            'contact.function' => ['required']
        ];
    }


}
