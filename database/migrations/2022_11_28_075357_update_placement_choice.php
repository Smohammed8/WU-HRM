<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlacementChoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('placement_choices', function (Blueprint $table) {
            $table->float('choice_one_result')->nullable();
            $table->float('choice_two_result')->nullable();
            $table->integer('choice_one_rank')->nullable();
            $table->integer('choice_two_rank')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
