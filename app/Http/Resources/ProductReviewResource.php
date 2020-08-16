<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
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

            'rating' => $this->rating,

            'review' => $this->review,

            'user' => [
                
                'id' => $this->user->id,

                'name' => $this->user->name,

                'avatar' => $this->user->avatar

            ]
        ];
    }
}
