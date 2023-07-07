<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'day.date' => ['required','date_format:'.custom('date_format')],
            'day.am_end' => ['nullable','required_with:day.am_start','after:day.am_start'],
            'day.pm_end' => ['nullable','required_with:day.pm_start','after:day.pm_start'],
            'day.am_start' => ['nullable','required_with:day.am_end','before:day.am_end'],
            'day.pm_start' => ['nullable','required_with:day.pm_end','before:day.pm_end','after:day.am_end'],
        ];

    }
}
