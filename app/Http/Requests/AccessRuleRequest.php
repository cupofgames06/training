<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class AccessRuleRequest extends FormRequest
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
        $indicators = \App\Models\Indicator::get()->pluck('id')->toArray();
        $fields = 'access_rules.rule.indicators.'.implode(',access_rules.rule.indicators.',$indicators );
        return [
            'access_rules.rule.required_courses' => 'array|required_without_all:'.$fields,
            'access_rules.rule.indicators.*' => 'required_without_all:'.$fields.',access_rules.rule.required_courses',
        ];
    }

}
