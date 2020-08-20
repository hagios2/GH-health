<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminViewUsersResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($user){
        
            return  [

                
            'id' => $user->id,

            'name' => $user->name,

            'email' => $user->email,

            'phone' => $user->phone,

            'campus' => $user->campus
            
            ];
        });
    }
}
