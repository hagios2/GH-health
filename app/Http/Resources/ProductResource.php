<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request): \Illuminate\Support\Collection
    {
        return $this->collection->map(function($product){
            return  [

                'id' => $product->id,

                'name' => $product->name,

                'quantity' => $product->quantity,

                'description' => $product->description,

                'source' => $product->source,

                'brand' => $product->brand,

                'expiry_date' => $product->expiry_date
           ];
        });
    }
}
