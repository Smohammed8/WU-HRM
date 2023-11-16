<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('pensions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('gender', ["Male","Female"]);
            $table->integer('year')->nullable();
            $table->integer('notify')->nullable();
            $table->integer('extend_year')->nullable();
            $table->foreignId('employee_category_id')->constrained()->nullable();
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
        Schema::dropIfExists('pensions');
    }
}
