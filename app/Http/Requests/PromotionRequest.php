<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            'promotion.date_start' => ['nullable','date_format:'.custom('date_format'),'before:promotion.date_end'],
            'promotion.date_end' => ['nullable','date_format:'.custom('date_format'),'after:promotion.date_start'],
        ];

    }

}
