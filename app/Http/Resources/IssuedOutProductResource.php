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

                'product_id' => $issued_product->product_id,

                'product_name' => $issued_product->product->name,

                'date_issued' => Carbon::parse($issued_product->date_issued),

                'issued_by' => $issued_product->issuedBy->name,

                'name_of_patient' => $issued_product->name_of_patient,

                'age_of_patient' => $issued_product->age_of_patient,

                'gender' => $issued_product->gender,

                'quantity' => $issued_product->quantity,

                'quantity_before_issued_out' => $issued_product->quantity_before_issued_out,

                'town' => $issued_product->town,

                'district' => $issued_product->district ? $issued_product->district->name : 'Not found'

            ];
        });
    }
}
