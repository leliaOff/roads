<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoadWorks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('performer')->nullable();
            $table->string('reason')->nullable();
            $table->string('trouble_type')->nullable();
            $table->string('repair_kind')->nullable();
            $table->string('road_type')->nullable();
            $table->string('road_name')->nullable();
            $table->string('road_code')->nullable();
            $table->string('region_code')->nullable();
            $table->string('region_name')->nullable();
            $table->date('work_started_at');
            $table->date('work_finished_at');
            $table->date('work_actually_started_at')->nullable();
            $table->date('work_actually_finished_at')->nullable();
            $table->string('start_lat');
            $table->string('start_lon');
            $table->string('end_lat');
            $table->string('end_lon');
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
        Schema::dropIfExists('road_works');
    }
}
