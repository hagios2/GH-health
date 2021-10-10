<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IssuedOutProductResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function($issued_product){

            return  [

                'victim_id' => $issued_product->victim->id,

                'victim_name' => $issued_product->victim->name,

                'victim_age' => Carbon::parse($issued_product->victim->dob)->age,

                'gender' => $issued_product->victim->gender,

                'product_id' => $issued_product->product_id,

                'product_name' => $issued_product->product->name,

                'current_product_quantity' => $issued_product->product->quantity,

                'date_issued' => Carbon::parse($issued_product->date_issued)->format('D, d F Y'),

                'issued_by' => $issued_product->issuedBy->name,

                'quantity_issued_out' => $issued_product->quantity,

                'quantity_before_issued_out' => $issued_product->quantity_before_issued_out,

                'town' => $issued_product->town,

                'district' => $issued_product->district ? $issued_product->district->name : 'Not found',

                'quantity_after_issued_out' => $issued_product->quantity_after_issued_out,

            ];
        });
    }
}
