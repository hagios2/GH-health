<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchandiserResource extends JsonResource
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

            'company_name' => $this->company_name,

            'email' => $this->email,

            'company_description' => $this->company_description,

            'avatar' => $this->avatar,

            'cover_photo' => $this->cover_photo,

            'campus' => $this->campus->campus,

            'phone' => $this->phone
        ];
    }
}
