<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleDetailsTable extends Migration
{
  
    public function up()
    {
        Schema::create('people_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('people_id');
            $table->string('email')->unique()->nullable();
            $table->string('cnic',13)->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('license_no',10)->nullable();
            $table->string('age',2)->nullable();
            $table->date('expire_date')->nullable();
            $table->string('vehicle_registration',10)->nullable();
            $table->string('car_year',10)->nullable();
            $table->string('make',25)->nullable();
            $table->string('modal',10)->nullable();
            $table->string('color',10)->nullable();
            $table->unsignedTinyInteger('seat')->nullable();
            $table->string('tax_pic')->nullable();
            $table->string('profile_pic')->nullable();
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
        Schema::dropIfExists('people_details');
    }
}
