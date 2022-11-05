<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Location;
use App\Models\Accomodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Accomodation\AccomodationResource;
use App\Http\Resources\Accomodation\AccomodationCollection;
use App\Http\Requests\Accomodation\CreateAccomodationRequest;

class AccomodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AccomodationCollection(Accomodation::all());
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
     * @param  \App\Http\Requests\StoreAccomodationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAccomodationRequest $request)
    {
        $accomodation = new Accomodation();
        $location = new Location();
        $validated_data = $request->validated();
        try {
            DB::beginTransaction();
            $location->city()->associate(City::find($validated_data["city_id"]));
            $location->gps_longitude = $validated_data["gps_longitude"];
            $location->gps_latitude = $validated_data["gps_latitude"];
            $location->save();

            $accomodation->designation = $validated_data["designation"];
            $accomodation->avg_price = $validated_data["avg_price"];
            $accomodation->avg_ratings = $validated_data["avg_ratings"];
            $accomodation->location_id = $location->id;

            $accomodation->save();
            DB::commit();

            return new AccomodationResource($accomodation);
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
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function show(Accomodation $accomodation)
    {
        return new AccomodationResource($accomodation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function edit(Accomodation $accomodation)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccomodationRequest  $request
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function update()
    {//CreateAccomodationRequest $request, Accomodation $accomodation
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accomodation $accomodation)
    {
        $accomodation->delete();
        return new AccomodationResource($accomodation);
    }
}
