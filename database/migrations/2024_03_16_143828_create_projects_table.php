<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->text('project_img')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('tech_stack')->nullable();
            $table->integer('project_category')->nullable();
            $table->string('db_name')->nullable();
            $table->integer('project_progress')->nullable();
            $table->date('deadline')->nullable();
            $table->string('project_price')->nullable();
            $table->integer('project_status')->default(1);
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
        Schema::dropIfExists('projects');
    }
}
