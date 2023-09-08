<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
          //  $table->integer('year')->nullable();

            $table->enum('year', ["2015","2016","2017","2018","2019","2020","2022","2023","2024","2025","2026"])->nullable();
            $table->enum('month', [ "July", "August", "September", "October", "November", "December","January", "February", "March", "April", "May","June"])->nullable();
          //  $table->integer('month')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
          //  $table->date('created_at')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
