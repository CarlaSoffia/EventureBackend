<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eateries', function (Blueprint $table) {
            $table->id();
            $table->string("designation");
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->float('avg_price', 5, 2);
            $table->float('avg_ratings');
            $table->double('gps_latitude');
            $table->double('gps_longitude');
        });
        Schema::create('accomodations', function (Blueprint $table) {
            $table->id();
            $table->string("designation");
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->float('avg_price', 5, 2);
            $table->float('avg_ratings');
            $table->double('gps_latitude');
            $table->double('gps_longitude');
        });
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string("designation");
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->float('avg_price', 5, 2);
            $table->float('avg_ratings');
            $table->double('gps_latitude');
            $table->double('gps_longitude');
            $table->bigInteger("avg_time_minutes")->nullable();
        });
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('days');
            $table->unsignedBigInteger('accomodation_id');
            $table->foreign('accomodation_id')->references('id')->on('accomodations');
            $table->float("avg_distance");
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
        });
        Schema::create('travels_eateries', function (Blueprint $table) {
            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travels');
            $table->unsignedBigInteger('eatery_id');
            $table->foreign('eatery_id')->references('id')->on('eateries');
        });
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travel_id');
            $table->foreign('travel_id')->references('id')->on('travels');
            $table->float("progress");
            $table->bigInteger("avg_time_minutes");
        });
        Schema::create('routes_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->enum("status", ["Started","On Going","Finished"]);
        });
        Schema::create('routes_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('accomodations');
        Schema::dropIfExists('eateries');
    }
};
