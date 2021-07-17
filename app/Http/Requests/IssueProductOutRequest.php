<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueProductOutRequest extends FormRequest
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
            'name_of_patient' => 'required|string',
            'town' => 'required|string',
            'district_id' => 'required|integer',
            'age_of_patient' => 'required|integer',
            'quantity' => 'required|integer',
            'date_issued' => 'required|date',
            'gender' => 'required|string'
        ];
    }
}
