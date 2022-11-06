<?php

namespace App\Http\Resources\Activity;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Undefined;

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
        $activity = $this;
       if(isset($this->route_id)){
          $activity = Activity::find($this->activity_id);
       }
        $location = Location::find($activity->location_id);
        $category = Category::find($activity->category_id);
        return [
            'id' => $activity->id,
            'designation' => $activity->designation,
            'avg_price' => $activity->avg_price,
            'avg_ratings' => $activity->avg_ratings,
            'avg_time_minutes' => $activity->avg_time_minutes,
            'category' => $category->name,
            'gps_latitude' => $location->gps_latitude,
            'gps_longitude' => $location->gps_longitude
        ];

    }
}
