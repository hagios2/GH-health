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


            'id' => $product->id,
                    
            'product_name' => $product->product_name,

            'price' => $product->price,

            'product_image' => ProductImage::where('product_id', $product->id)->latest()->take(1)->get('path')
        ];
    }
}
