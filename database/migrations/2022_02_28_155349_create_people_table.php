<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type')->default(0)->comment('0 = passenger and 1 = captain'); 
            $table->boolean('role')->default(0)->comment('0 = passenger and 1 = captain'); 
            $table->string('fname');  //fullname
            $table->string('password');
            $table->string('contact_no',15)->unique()->nullable();
            $table->boolean('verified')->default(0)->comment('0 = non-verified and 1 = verified'); 
            $table->boolean('active')->default(1)->comment('0 = inactive and 1 = active'); 
            $table->boolean('forgot')->nullable()->comment('null = not forgot and 1 = forgot'); 
            $table->string('otp',4)->nullable();
            $table->string('temp_code',15)->nullable();
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
        Schema::dropIfExists('people');
    }
}
