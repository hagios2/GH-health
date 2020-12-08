<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllShopsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($shop){

            return  [

                'id' => $shop->id,

                'company_name' => $shop->company_name,

                'company_description' => $shop->company_description,

                'avatar' => $shop->avatar,

                'number_of_followers' => $shop->followers->count(),

                'valid_id' => $shop->valid_id,

                'cover_photo' => $shop->cover_photo,

                'campus' => [

                    'id' => $shop->campus->id,

                    'campus' => $shop->campus->campus
                ]
            ];
        });
    }
}
