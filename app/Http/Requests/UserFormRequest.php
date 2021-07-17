<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $form_requests = [

            'name' => 'required|string',

            'phone' => 'required|numeric|unique:users,phone',

            'avatar' => 'nullable|image|mimes:jpeg,jpg,png',

            'facility_id' => 'required|integer'
        ];

        if(request()->method() === 'POST')
        {
            $form_requests['email'] = 'required|email|unique:users,email';

        }else{
            $form_requests['email'] = 'required|email';
        }

        return $form_requests;
    }
}
