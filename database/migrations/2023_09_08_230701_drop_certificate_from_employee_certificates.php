<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCertificateFromEmployeeCertificates extends Migration
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
            $table->dropForeign('employee_certificates_employee_certificate_id_foreign');
            
            // Drop the column
            $table->dropColumn('employee_certificate_id');

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
            $table->unsignedBigInteger('employee_certificate_id');
            
            // Add the foreign key constraint back
            $table->foreign('employee_certificate_id')->references('id')->on('employee_certificates');
        });
    }
}
