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
            'victim_id' => 'required|integer',
            'town' => 'required|string',
            'district_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'date_issued' => 'required|date',
            'issued_by' => 'required|string'
        ];
    }
}
