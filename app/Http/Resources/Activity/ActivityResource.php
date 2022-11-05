<?php

namespace App\Http\Resources\Activity;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
        $category = Category::find($this->category_id);
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'avg_price' => $this->avg_price,
            'avg_ratings' => $this->avg_ratings,
            'avg_time_sec' => $this->avg_time_sec,
            'category' => $category->name,
            'gps_latitude' => $location->gps_latitude,
            'gps_longitude' => $location->gps_longitude
        ];
    }
}
