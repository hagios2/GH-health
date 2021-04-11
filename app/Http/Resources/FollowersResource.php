<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowersResource extends JsonResource
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

            'shop_id' => $this->merchandiser_id,

            'shop_name' => $this->shop ? $this->shop->company_name : 'not found',

            'company_description' => $this->shop ? $this->shop->company_description : 'not found',

            'number_of_followers' => $this->shop ? $this->shop->followers->count() : 'not found',

            'campus' => [

                'id' => $this->shop ? $this->shop->campus->id : 'not found',

                'campus' => $this->shop ? $this->shop->campus->campus : 'not found',
            ]
        ];
    }
}
