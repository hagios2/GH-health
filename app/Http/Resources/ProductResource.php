<?php

namespace App\Http\Resources;

use App\Models\ProductImage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
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
            $this->collection->map(function($product){
                return  [

                    'id' => $product->id,

                    'name' => $product->name,

                    'quantity' => $product->quanity,

                    'description' => $product->description,

                    'product_image' => ProductImage::where('product_id', $product->id)->latest()->take(1)->get('path')
               ];
            }),

       ];
    }
}
