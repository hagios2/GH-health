<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionsRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'name_of_regional_minister' => 'nullable|string',
            'address_of_regional_minister' => 'nullable|string',
            'name_of_director_general' => 'nullable|string',
            'address_of_director_general' => 'nullable|string',
            'name_of_regional_health_director' => 'nullable|string',
            'address_of_regional_health_director' => 'nullable|string'
        ];
    }
}
