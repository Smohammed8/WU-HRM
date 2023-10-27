<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateEmployeeHorizontalLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE employees MODIFY COLUMN horizontal_level ENUM('Start', '1', '2', '3', '4', '5', '6', '7','8','9','Ceil')");
        // Schema::table('employees', function (Blueprint $table) {
        //     $table->enum('blood_group', ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"])->nullable()->change();
        // });
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
