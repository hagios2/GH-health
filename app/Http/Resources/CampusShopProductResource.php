<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\ProductImage;

class CampusShopProductResource extends JsonResource
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
                    
            'product_name' => $this->product_name,

            'price' => $this->price,

            'product_image' => ProductImage::where('product_id', $this->id)->latest()->take(1)->get('path')
        ];
    }
}
