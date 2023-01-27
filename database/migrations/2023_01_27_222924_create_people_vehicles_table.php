<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('people_id');
            $table->string('vehicle_registration',10)->nullable();
            $table->string('make',25)->nullable();
            $table->string('modal',10)->nullable();
            $table->string('car_year',10)->nullable();
            $table->string('color',10)->nullable();
            $table->unsignedTinyInteger('seat')->nullable();
            $table->string('tax_pic')->nullable();
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
        Schema::dropIfExists('people_vehicles');
    }
}
