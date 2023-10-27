<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSkillTypeFromEmployeeCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

         Schema::table('employee_certificates', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign('employee_certificates_skill_type_id_foreign');
            
            // Drop the column
            $table->dropColumn('skill_type_id');

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_certificates', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('skill_type_id');
            
            // Add the foreign key constraint back
            $table->foreign('skill_type_id')->references('id')->on('skill_types');
        });
    }
}
