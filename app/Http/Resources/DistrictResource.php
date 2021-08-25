<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            'name' => $this->name,
            'region' => $this->region,
            'lat' => $this->lat,
            'long' => $this->long,
            'address_of_district_health_directorate' => $this->address_of_district_health_directorate
        ];
    }
}
