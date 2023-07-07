<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileRequest extends FormRequest
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
