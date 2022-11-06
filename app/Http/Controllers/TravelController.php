<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Route;
use App\Models\Travel;
use App\Models\Location;
use App\Models\Accomodation;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Travel\TravelResource;
use App\Http\Resources\Travel\TravelCollection;
use App\Http\Requests\Travel\CreateTravelRequest;

class TravelController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TravelCollection(Travel::all());
    }

    public function eateries(Travel $travel)
    {
        $eateries = DB::table('travels_eateries')
        ->where('travel_id','=',$travel->id)
        ->get();
        return new TravelCollection($eateries);
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

    function twopoints_on_earth($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
	{
        return round((((acos(sin(($latitudeFrom*pi()/180)) * sin(($latitudeTo*pi()/180))+cos(($latitudeFrom*pi()/180)) * cos(($latitudeTo*pi()/180)) * cos((($longitudeFrom- $longitudeTo)*pi()/180))))*180/pi())*60*1.1515*1.609344), 2);
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTravelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTravelRequest $request)
    {
        $travel = new Travel();
        $route = new Route();
        $validated_data = $request->validated();
        $accomodation = Accomodation::find($validated_data["accomodation_id"]);
        try {
            DB::beginTransaction();
            $travel->days = $validated_data["days"];
            $travel->avg_distance = $validated_data["avg_distance"];
            $travel->city()->associate(City::find($validated_data["city_id"]));
            $travel->user()->associate(User::find($validated_data["user_id"]));
            $travel->accomodation()->associate($accomodation);

            $activities = DB::table('activities')
                                ->join('locations', 'activities.location_id', '=', 'locations.id')
                                ->join('cities', 'locations.city_id', '=', 'cities.id')
                                ->where('cities.id','=',$validated_data["city_id"])
                                ->select(["activities.id","activities.avg_time_minutes","locations.gps_longitude","locations.gps_latitude"])
                                ->get();
            $eateries = DB::table('eateries')
                                ->join('locations', 'eateries.location_id', '=', 'locations.id')
                                ->join('cities', 'locations.city_id', '=', 'cities.id')
                                ->where('cities.id','=',$validated_data["city_id"])
                                ->select("eateries.id")
                                ->get();
            $travel->save();
            foreach ($eateries as $eatery){
                $travel->eateries()->attach($eatery);
            }

            $travel->save();
            DB::commit();
            DB::beginTransaction();
            $time = 0;
            $routeActivities=[];
           foreach ($activities as $activity) {
                $accomodationLocation = Location::find($accomodation->location_id);
                $distance = $this->twopoints_on_earth($accomodationLocation->gps_latitude, $accomodationLocation->gps_longitude, $activity->gps_latitude,  $activity->gps_longitude);

               if($distance <= $validated_data["avg_distance"]) {
                    array_push($routeActivities,$activity);
                    $time = $time + $activity->avg_time_minutes;
               }
            }
            if($time > 0){
                $route->progress = 0;
                $route->avg_time_minutes = $time;
                $route->travel()->associate($travel);
                $route->save();
            }
            DB::commit();
            DB::beginTransaction();
            foreach($routeActivities as $act){
                $route->activities()->attach($act->id);
            }
            $route->save();
            DB::commit();
            return new TravelResource($travel);
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
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function show(Travel $travel)
    {
        return new TravelResource($travel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function edit(Travel $travel)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        $travel->delete();
        return new TravelResource($travel);
    }
}
