<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GibddOnline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gibdd_online', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('transport_number');
            $table->dateTime('offence_registered_at');
            $table->string('lat');
            $table->string('lon');
            $table->integer('user_id');
            $table->json('files');
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
        Schema::dropIfExists('gibdd_online');
    }
}
