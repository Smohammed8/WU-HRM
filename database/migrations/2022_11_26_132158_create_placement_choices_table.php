<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacementChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('placement_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_round_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('choice_one_id')->constrained('positions');
            $table->foreignId('choice_two_id')->constrained('positions');
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
        Schema::dropIfExists('placement_choices');
    }
}
