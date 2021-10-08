<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VictimResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request): \Illuminate\Support\Collection
    {
        return $this->collection->map(function ($victim){

            return [
                    'id' => $victim->id,

                    'name' => $victim->name,

                    'age' => Carbon::parse($victim->dob)->age,

                    'town' => $victim->town,

                    'district' => new DistrictResource($victim->district),

                    'gender' => $victim->gender
            ];
        });
    }
}
