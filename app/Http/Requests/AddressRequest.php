<?php

namespace App\Http\Requests;

use App\Rules\SiretVerif;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AddressRequest extends FormRequest
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
            'address.street_number' => ['required'],
            'address.street_name' => ['required'],
            'address.postal_code' => ['required'],
            'address.city' => ['required'],
            'address.country_iso' => ['required']
        ];

    }

}
