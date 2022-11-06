<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Travel;
use App\Models\Accomodation;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Travel\TravelResource;
use App\Http\Requests\Travel\CreateTravelRequest;
use App\Http\Resources\Travel\TravelCollection;

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
     * @param  \App\Http\Requests\StoreTravelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTravelRequest $request)
    {
        $travel = new Travel();
        $validated_data = $request->validated();

        try {
            DB::beginTransaction();
            $travel->days = $validated_data["days"];
            $travel->avg_distance = $validated_data["avg_distance"];
            $travel->city()->associate(City::find($validated_data["city_id"]));
            $travel->user()->associate(User::find($validated_data["user_id"]));
            $travel->accomodation()->associate(Accomodation::find($validated_data["accomodation_id"]));
            $travel->save();
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
