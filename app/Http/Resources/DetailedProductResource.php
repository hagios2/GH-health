<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
       return [
        'id' => $this->id,

        'name' => $this->name,

        'quantity' => $this->quantity, #subtract from puchased from this

        'description' =>  $this->description,

        'source' => $this->source,

        'brand' => $this->brand,

        'expiry_date' => Carbon::parse($this->expiry_date)->format('D, d F Y'),

        'received_by' => $this->receivedBy ? $this->receivedBy->name : 'Not found' ,

//        'product_images' => ProductImageResource::collection($this->image),
       ];
    }
}
