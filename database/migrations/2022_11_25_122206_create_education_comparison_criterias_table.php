<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationComparisonCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('education_comparison_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_value_id')->constrained();
            $table->foreignId('educational_level_id')->constrained();
            $table->foreignId('min_educational_level_id')->constrained();
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
        Schema::dropIfExists('education_comparison_criterias');
    }
}
