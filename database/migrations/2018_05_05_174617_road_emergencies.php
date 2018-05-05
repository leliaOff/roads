<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoadEmergencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_emergencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reg_code');
            $table->string('reg_name');
            $table->date('date');
            $table->string('kind');
            $table->longText('description');
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
        Schema::dropIfExists('road_emergencies');
    }
}
