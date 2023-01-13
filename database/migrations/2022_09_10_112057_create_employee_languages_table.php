<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('employee_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('language_id')->constrained();
            $table->enum('speaking', ["Basic","Fair","Good","Fluent","Mather Taunt"]);
            $table->enum('reading', ["Excellent","Good","Fair","Poor","No"]);
            $table->enum('writing', ["Excellent","Good","Fair","Poor","No"]);
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('employee_languages');
    }
}
