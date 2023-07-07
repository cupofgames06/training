<?php

namespace App\Http\Requests;

use App\Models\Learner;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param $id
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules($prefix = 'user'): array
    {
        $id = request()->route()->parameter($prefix);
        if (!empty($id)) {
            $id = ',' . $id;
        }

        return [
            'user.email' => ['email', 'max:255', 'unique:users,email' . $id],
            'user.password' => ['nullable', 'min:8']
        ];
    }
}
