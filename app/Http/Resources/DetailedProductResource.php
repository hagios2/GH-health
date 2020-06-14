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

        $productOwner = [];

        if($this->merchandiser)
        {
            $productOwner['merchandiser_id'] = $this->merchandiser->id;
                
            $productOwner['company_name'] = $this->merchandiser->company_name;

            $productOwner['avatar'] = $this->merchandiser->avatar;
        
        }else if($this->user){

            $productOwner['user_id'] = $this->user->id;
                
            $productOwner['name'] = $this->user->name;

            $productOwner['avatar'] = $this->user->avatar;
        }


       return [

                'id' => $this->id,

                'product_name' => $this->product_name,

                'price' => $this->price,

                'in_stock' => $this->in_stock, #subtract from puchased from this

                'description' =>  $this->description,

                'product_owner' => $productOwner,

                'product_images' => ProductImageResource::collection($this->image), //path

       ];
    }
}
