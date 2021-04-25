<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminViewShopReport extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($report) {

            return [

                'id' => $report->id,

                'report' => $report->report,

                'user' => [

                    'id' => $report->user_id,

                    'name' => $report->user->name,

                    'email' => $report->user->email
                ],

                'shop' => [

                    'id' => $report->merchandiser_id,

                    'shop_name' => $report->shop->company_name
                ]

            ];
        });
    }
}
