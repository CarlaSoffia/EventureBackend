<?php

namespace App\Http\Resources\Eatery;

use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Location\LocationResource;

class EateryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       $location = Location::find($this->location_id);

       return [
            'id' => $this->id,
            'designation' => $this->designation,
            'avg_price' => $this->avg_price,
            'avg_ratings' => $this->avg_ratings,
            'gps_latitude' => $location->gps_latitude,
            'gps_longitude' => $location->gps_longitude
        ];
    }
}
