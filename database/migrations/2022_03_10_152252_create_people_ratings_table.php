<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_ratings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('captain_id');
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('passenger_id');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->boolean('active')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('people_ratings');
    }
}
