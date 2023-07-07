<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class ClassroomRequest extends FormRequest
{
    //use ValidatesMedia;

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
        $address_request = new AddressRequest();

        return array_merge(
            [
                /*'entity.reg_number' => ['required'],
                'entity.name' => ['required']*/

            ],
            $address_request->rules()
        );

    }

}
