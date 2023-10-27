<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCollegePositionCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('college_position_codes', function (Blueprint $table) {
              $table->renameColumn('college','college_id');
           });
    }

  //  $table->foreignId('college')->nullable()->constrained('hr_branches');

    public function down()
    {
           Schema::table('college_position_codes', function (Blueprint $table) {
                 $table->renameColumn('college','college_id');
           });
    }
}
