<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleIssuedOutProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'victim_id' => $this->victim->id,

            'victim_name' => $this->victim->name,

            'victim_age' => Carbon::parse($this->victim->dob)->age,

            'gender' => $this->victim->gender,

            'product_id' => $this->product_id,

            'product_name' => $this->product->name,

            'current_product_quantity' => $this->product->quantity,

            'date_issued' => Carbon::parse($this->date_issued)->parse('D, d F Y'),

            'issued_by' => $this->issuedBy->name,

            'quantity_issued_out' => $this->quantity,

            'quantity_before_issued_out' => $this->quantity_before_issued_out,

            'town' => $this->town,

            'district' => $this->district ? $this->district->name : 'Not found',

            'quantity_after_issued_out' => $this->quantity_after_issued_out,
        ];
    }
}
