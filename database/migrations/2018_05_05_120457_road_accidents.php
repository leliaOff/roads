<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoadAccidents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_accidents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('crash_type')->nullable();
            $table->string('crash_reason')->nullable();
            $table->string('road_type')->nullable();
            $table->string('road_name')->nullable();
            $table->string('road_code')->nullable();
            $table->string('region_code')->nullable();
            $table->string('region_name')->nullable();
            $table->date('crash_date');
            $table->string('lat');
            $table->string('lon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('road_accidents');
    }
}
