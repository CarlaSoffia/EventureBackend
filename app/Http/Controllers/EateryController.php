<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Eatery;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Eatery\EateryResource;
use App\Http\Resources\Eatery\EateryCollection;
use App\Http\Requests\Eatery\CreateEateryRequest;

class EateryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new EateryCollection(Eatery::all());
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
     * @param  \App\Http\Requests\StoreEateryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEateryRequest $request)
    {
        $eatery = new Eatery();
        $location = new Location();
        $validated_data = $request->validated();
        try {
            DB::beginTransaction();
            $location->city()->associate(City::find($validated_data["city_id"]));
            $location->gps_longitude = $validated_data["gps_longitude"];
            $location->gps_latitude = $validated_data["gps_latitude"];
            $location->save();

            $eatery->designation = $validated_data["designation"];
            $eatery->avg_price = $validated_data["avg_price"];
            $eatery->avg_ratings = $validated_data["avg_ratings"];
            $eatery->location_id = $location->id;

            $eatery->save();
            DB::commit();

            return new EateryResource($eatery);
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
     * @param  \App\Models\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function show(Eatery $eatery)
    {
        return new EateryResource($eatery);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function edit(Eatery $eatery)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEateryRequest  $request
     * @param  \App\Models\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function update()
    {//CreateEateryRequest $request, Eatery $eatery
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eatery  $eatery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eatery $eatery)
    {
        $eatery->delete();
        return new EateryResource($eatery);
    }
}
