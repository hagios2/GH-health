<?php

namespace App\Http\Resources;

use App\Http\Resources\CampusShopProductResource;

use Illuminate\Http\Resources\Json\JsonResource;

class CampusShopAndProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [


            'id' => $this->id,

            'company_name' => $this->company_name,

            'company_description' => $this->company_description,

            'product' => CampusShopProductResource::collection($this->product->take(4))
        ];
    }
}
