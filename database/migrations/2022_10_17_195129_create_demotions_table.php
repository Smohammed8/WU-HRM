<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('demotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('old_unit_id')->constrained('units');
            $table->foreignId('new_unit_id')->constrained('units');
            $table->foreignId('old_job_title_id')->constrained('job_titles');
            $table->foreignId('new_job_title_id')->constrained('job_titles');
            $table->foreignId('created_by_id')->constrained('users')->nullable();
            $table->text('reason_of_demotion')->nullable();
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
        Schema::dropIfExists('demotions');
    }
}
