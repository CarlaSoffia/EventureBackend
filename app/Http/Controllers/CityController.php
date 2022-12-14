<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\City\CityCollection;
use App\Http\Requests\City\CreateCityRequest;
use App\Http\Resources\Eatery\EateryCollection;
use App\Http\Resources\Activity\ActivityCollection;
use App\Http\Resources\Accomodation\AccomodationCollection;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CityCollection(City::all());
    }

    public function eateries(City $city)
    {
        $eateriesByCity = DB::table('eateries')
                ->join('locations', 'eateries.location_id', '=', 'locations.id')
                ->where('city_id','=',$city->id)
                ->get();
        return new EateryCollection($eateriesByCity);
    }

    public function accomodations(City $city)
    {
        $accomodationsByCity = DB::table('accomodations')
                ->join('locations', 'accomodations.location_id', '=', 'locations.id')
                ->where('city_id','=',$city->id)
                ->get();
        return new AccomodationCollection($accomodationsByCity);
    }

    public function activities(City $city)
    {
        $activitiesByCity = DB::table('activities')
                ->join('locations', 'activities.location_id', '=', 'locations.id')
                ->where('city_id','=',$city->id)
                ->get();
        return new ActivityCollection($activitiesByCity);
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
     * @param  \App\Http\Requests\StoreCityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        $city = new City();
        $validated_data = $request->validated();

        try {
            DB::beginTransaction();

            $city->name = strtolower($validated_data["name"]);
            $city->country()->associate(Country::find($validated_data["country_id"]));
            $city->save();
            DB::commit();

            return new CityResource($city);
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return new CityResource($city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCityRequest  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update()
    {//CreateCityRequest $request, City $city
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return new CityResource($city);
    }
}
