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
        Schema::table('eateries', function (Blueprint $table) {
            $table->dropColumn('gps_longitude');
            $table->dropColumn('gps_latitule');
        });
        Schema::table('accomodations', function (Blueprint $table) {
            $table->dropColumn('gps_longitude');
            $table->dropColumn('gps_latitule');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('gps_longitude');
            $table->dropColumn('gps_latitule');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->double('gps_latitule')->nullable();
            $table->double('gps_longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
