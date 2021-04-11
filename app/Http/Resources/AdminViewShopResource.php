<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminViewShopResource extends ResourceCollection
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

                /* 'company_description' => $this->company_description,

                'avatar' => $this->avatar,

                'number_of_followers' => $this->followers->count(), */

                'campus' => $shop->campus,

                'isActive' => $shop->isActive,

                'created_at' => Carbon::parse($shop->created_at)->format('D, d F Y')
            ];

        });
    }
}
