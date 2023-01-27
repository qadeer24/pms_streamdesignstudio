<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
           
            $table->unsignedInteger('passenger_id'); 
            $table->unsignedInteger('schedule_id');
            
            $table->unsignedTinyInteger('book_seat')->default(0);
            $table->text('arrangment')->nullable();

            $table->unsignedTinyInteger('cancel_reason_id')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->boolean('cancel')->default(0);
            $table->boolean('complete')->default(0);
            
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
        Schema::dropIfExists('bookings');
    }
}
