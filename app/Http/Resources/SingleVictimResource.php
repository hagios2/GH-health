<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleVictimResource extends JsonResource
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

            'age' => Carbon::parse($this->dob)->age,

            'town' => $this->town,

            'district' => new DistrictResource($this->district),

            'gender' => $this->gender,

            "created_at" => Carbon::parse($this->created_at_)->format('D, d F Y')
        ];
    }
}
