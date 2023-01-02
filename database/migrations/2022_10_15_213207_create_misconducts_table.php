<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisconductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('misconducts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('type_of_misconduct_id')->constrained('type_of_misconducts');
            $table->foreignId('created_by_id')->constrained('users')->nullable();
            $table->string('attachement', 255)->nullable();
            $table->text('action_taken')->nullable();
            $table->enum('serverity', ["High","Medium","Low"]);
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
        Schema::dropIfExists('misconducts');
    }
}
