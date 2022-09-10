<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingAndStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('training_and_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->string('name', 255);
            $table->foreignId('nationality_id')->constrained();
            $table->foreignId('educational_level_id')->constrained();
            $table->string('inistitution', 255);
            $table->string('city', 255);
            $table->boolean('is_contract');
            $table->date('date_of_leave');
            $table->date('end_of_study');
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
        Schema::dropIfExists('training_and_studies');
    }
}
