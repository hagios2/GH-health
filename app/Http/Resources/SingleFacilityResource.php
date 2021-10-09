<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleFacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
       return [
            'id' => $this->id,
            'name' => $this->name,
            'lat' => $this->lat,
            'long' => $this->long,
            'district' => new DistrictResource($this->district),
           "created_at" => Carbon::parse($this->created_at_)->format('D, d F Y')
        ];
    }
}
