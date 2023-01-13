<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('job_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained();
            $table->string('start_salary');
            $table->string('one');
            $table->string('two');
            $table->string('three');
            $table->string('four');
            $table->string('five');
            $table->string('six');
            $table->string('seven');
            $table->string('eight');
            $table->string('nine');
            $table->string('ceil_salary');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_grades');
    }
}
