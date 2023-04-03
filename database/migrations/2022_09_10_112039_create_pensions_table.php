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
            $table->integer('year')->default(60);
            $table->integer('notify')->default(365);
            $table->integer('extend_year')->default(60);
            $table->foreignId('employee_category_id')->constrained();
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
