<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class IssuedOutProductResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function toArray($request): Collection
    {
        return $this->collection->map(function($issued_product){

            return  [

                'victim_id' => $issued_product->victim ? $issued_product->victim->id : 'Not found',

                'victim_name' => $issued_product->victim->name ?? 'Not found',

                'victim_age' => $issued_product->victim ? Carbon::parse($issued_product->victim->dob)->age : 'Not found',

                'gender' => $issued_product->victim->gender ?? 'Not found',

                'product_id' => $issued_product->product_id ?? 'Not found',

                'product_name' => $issued_product->product->name ?? 'Not found',

                'current_product_quantity' => $issued_product->product->quantity ?? 'Not found',

                'date_issued' => Carbon::parse($issued_product->date_issued)->format('D, d F Y'),

                'issued_by' => $issued_product->issuedBy->name ?? 'Not found',

                'quantity_issued_out' => $issued_product->quantity,

                'quantity_before_issued_out' => $issued_product->quantity_before_issued_out,

                'town' => $issued_product->town,

                'district' => $issued_product->district ? $issued_product->district->name : 'Not found',

                'quantity_after_issued_out' => $issued_product->quantity_after_issued_out,

            ];
        });
    }
}
