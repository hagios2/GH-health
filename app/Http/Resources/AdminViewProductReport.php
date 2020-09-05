<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminViewProductReport extends JsonResource
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

            'report' => $this->report,

            'user' => [

                'id' => $this->user_id,

                'name' => $this->user->name
            ],

            'product' => $this->product_id
        ];
    }
}
