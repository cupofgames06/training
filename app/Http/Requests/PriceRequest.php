<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
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
            'price.*.type' => ['required'],
            'price.*.price_ht' => ['required'],
            'price.*.price_ttc' => ['required'],
            'price.*.vat_rate' => ['required']
        ];

    }

}
