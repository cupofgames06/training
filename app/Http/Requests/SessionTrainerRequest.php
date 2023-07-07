<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionTrainerRequest extends FormRequest
{
    public function rules(): array
    {
        //todo : unique trainer par session
        return [
            'session_trainer.trainer_id' => 'required|sometimes',
        ];

    }
}
