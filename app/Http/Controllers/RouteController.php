<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Route\RouteResource;
use App\Http\Resources\Route\RouteCollection;
use App\Http\Requests\Route\CreateRouteRequest;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RouteCollection(Route::all());
    }


    public function activities(Route $route)
    {
        $activities = DB::table('routes_activities')
        ->where('route_id','=',$route->id)
        ->get();
        return new RouteCollection($activities);
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
     * @param  \App\Http\Requests\StoreRouteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRouteRequest $request)
    {
        //todo move to after travel creation
        $route = new Route();
        $validated_data = $request->validated();
        $time = DB::table('routes_activities')
            ->join('activities', 'routes_activities.activity_id', '=', 'activities.id')
            ->where('route_id','=',$route->id)
            ->sum('activities.avg_time_minutes');

        try {
            DB::beginTransaction();
            $route->travel()->associate(Travel::find($validated_data["travel_id"]));
            $route->progress = 0;
            $route->avg_time_minutes = $time;
            $route->save();
            DB::commit();

            return new RouteResource($route);
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
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        return new RouteResource($route);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        abort(404);
    }

    public function updateProgress(Route $route)
    {
        $activities = DB::table('routes_activities')
        ->where('route_id','=',$route->id)
        ->count();
        $completed = DB::table('routes_activities')
        ->where('route_id','=',$route->id)
        ->where('status','=','Finished')
        ->count();
        $route->progress = (100 * $completed) / $activities;
        $route->save();
        return new RouteResource($route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        $route->delete();
        return new RouteResource($route);
    }
}
