<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackRequest extends FormRequest
{
    public function rules(): array
    {
        $price_request = new PriceRequest();
        $locale = app()->getLocale();
        $id = request()->route()->parameter('pack');

        $rules = [
            'description.reference' => ['required'/*, 'unique:offer_descriptions,reference,' . $id*/],
            'description.name.' . $locale => ['required']
        ];

        if (request()->get('description')['intra'] == 1) {
            return $rules;
        }

        return array_merge($price_request->rules(), $rules);
    }
}
