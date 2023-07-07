<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    public function rules(): array
    {

        $course = Course::find(request()->get('session')['course_id']);
        $rules = [
            'session.course_id' => ['required'],
        ];

        if ( !empty($course) && $course->type == 'physical') {
            $rules['session.classroom_id'] = ['required'];
        }

        return $rules;
    }
}
