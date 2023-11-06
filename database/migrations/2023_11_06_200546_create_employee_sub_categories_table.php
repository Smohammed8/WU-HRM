<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('employee_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('employee_category_id')->nullable()->constrained();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('employee_sub_categories');
    }
}
