<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('round_id')->nullable()->constrained('placement_rounds');
            $table->string('first_name')->nullable();
            $table->string('father_name')->nullable();
            $table->enum('gender', ["Female","Male"])->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
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
        Schema::dropIfExists('committees');
    }
}
