<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained();
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->string('first_name', 255)->nullable();
            $table->string('father_name', 255)->nullable();
            $table->string('grand_father_name', 255)->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('field_of_study_id')->nullable()->constrained();
            $table->foreignId('educational_level_id')->nullable()->constrained();
            $table->float('gpa')->nullable();
            $table->enum('gender', ["Male","Female"])->nullable();
            $table->string('disablity_status')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->integer('year_of_graduation')->nullable();
            $table->foreignId('nationality_id')->nullable()->constrained();
            $table->integer('total_experience')->nullable()->default(0);
            $table->integer('job_position_experience')->nullable()->default(0);
            $table->float('mark')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
