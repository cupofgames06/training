<?php

namespace App\Http\Requests;

use App\Models\Learner;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LearnerUpdateUserRequest extends FormRequest
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
        $id = request()->route()->parameter('learner');
        $learner = Learner::find($id);
        if (!empty($learner)) {
            $id = ','.$id;
        }

        return [
            'user.email' => ['required', 'email', 'max:255', Rule::unique(User::class,'email')->ignore($id)],
        ];

    }

}
