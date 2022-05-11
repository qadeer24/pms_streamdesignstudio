<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('people_id')->nullable(); 
            $table->boolean('type')->default(0)->comment('0 = passenger and 1 = captain'); 
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('booking_id')->nullable();
            $table->text('detail')->nullable();
            $table->unsignedTinyInteger('status_id')->nullable();
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
        Schema::dropIfExists('histories');
    }
}
