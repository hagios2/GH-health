<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FacilityResources extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($facility){
            return [
                'name' => $facility->name,
                'lat' => $facility->lat,
                'long' => $facility->long,
                'district' => $facility->district
            ];
        });
    }
}
