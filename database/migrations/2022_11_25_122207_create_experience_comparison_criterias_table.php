<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceComparisonCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('experience_comparison_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_value_id')->constrained();
            $table->integer('min_year')->default(0);
            $table->integer('max_year')->nullable();
            $table->float('value');
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
        Schema::dropIfExists('experience_comparison_criterias');
    }
}
