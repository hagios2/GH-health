<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailedProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->merchandiser->isNotEmpty)
        {
            $productOwner = [

                'merchandiser_id' => $this->merchandiser->id,
                
                'company_name' => $this->merchandiser->company_name,

                'avatar' => $this->merchandiser->avatar
            ];
        
        }else if($this->user->isNotEmpty){

            $productOwner = [

                'user_id' => $this->user->id,
                
                'name' => $this->user->name,

                'avatar' => $this->user->avatar
            ];
        }


       return [

            'id' => $this->id,

            'product_name' => $this->product_name,

            'price' => $this->price,

            'in_stock' => $this->in_stock, #subtract from puchased from this

            $productOwner,

            'product_images' => $this->image->get('id', 'path'), //path

       ];
    }
}
