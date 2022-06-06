<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('captain_id');

            $table->unsignedInteger('pickup_city_id');
            $table->string('pickup_lat')->nullable();
            $table->string('pickup_lng')->nullable();
            $table->text('pickup_address')->nullable();
            // $table->time('pickup_time')->nullable();

            $table->unsignedInteger('dropoff_city_id');
            $table->string('dropoff_lat')->nullable();
            $table->string('dropoff_lng')->nullable();
            $table->text('dropoff_address')->nullable();
            // $table->time('dropoff_time');

            
            $table->date('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();

            $table->unsignedTinyInteger('vacant_seat')->default(0);
            $table->decimal('fare', $precision = 8, $scale = 2)->default(0);

            $table->unsignedTinyInteger('cancel_reason_id')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->boolean('show_contact')->nullable();

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
        Schema::dropIfExists('schedules');
    }
}
