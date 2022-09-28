<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinimumRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('minimum_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->integer('experience');
            $table->foreignId('educational_level_id')->constrained();
            $table->decimal('minimum_efficeny');
            $table->integer('minimum_employee_profile_value');
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
        Schema::dropIfExists('minimum_requirements');
    }
}
