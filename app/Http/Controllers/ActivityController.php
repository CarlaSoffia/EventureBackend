<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Activity;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\Activity\ActivityCollection;
use App\Http\Requests\Activity\CreateActivityRequest;

class ActivityController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ActivityCollection(Activity::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateActivityRequest $request)
    {
        $activity = new Activity();
        $location = new Location();
        $validated_data = $request->validated();
        try {
            DB::beginTransaction();
            $location->city()->associate(City::find($validated_data["city_id"]));
            $location->gps_longitude = $validated_data["gps_longitude"];
            $location->gps_latitude = $validated_data["gps_latitude"];
            $location->save();

            $activity->designation = $validated_data["designation"];
            $activity->avg_price = $validated_data["avg_price"];
            $activity->avg_ratings = $validated_data["avg_ratings"];
            $activity->location_id = $location->id;
            $activity->category_id = $validated_data["category_id"];
            $activity->avg_time_minutes = $validated_data["avg_time_minutes"];
            $activity->save();
            DB::commit();

            return new ActivityResource($activity);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  $th->getMessage()
            ), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return new ActivityResource($activity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateActivityRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update()
    {//CreateActivityRequest $request, Activity $activity
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return new ActivityResource($activity);
    }
}
