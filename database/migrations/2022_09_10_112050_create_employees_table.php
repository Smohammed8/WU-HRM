<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('father_name', 255);
            $table->string('grand_father_name', 255);
            $table->enum('gender', ["Male","Female"]);
            $table->date('date_of_birth');
            $table->string('photo')->nullable();
            $table->string('birth_city', 255);
            $table->string('passport', 255)->nullable();
            $table->string('driving_licence')->nullable();
            $table->enum('blood_group', ["A","B","AB","O"])->nullable();
            $table->enum('eye_color', ["Amber","Blue","Brown","Gray","Green","Hazel","Red"])->nullable();
            $table->string('phone_number', 100)->nullable();
            $table->string('alternate_email', 255)->nullable();
            $table->string('rfid', 100)->nullable();
            $table->integer('employment_identity')->nullable();
            $table->foreignId('marital_status_id')->constrained();
            $table->foreignId('ethnicity_id')->constrained();
            $table->foreignId('religion_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->date('employement_date');
            $table->enum('salary_step', ["Base","I","II","III","IV","V","Vi","VII","VIII","IX","Celing"])->nullable();
            $table->foreignId('job_title_id')->constrained();
            $table->foreignId('employment_type_id')->constrained();
            $table->integer('pention_number')->nullable();
            $table->foreignId('employment_status_id')->nullable()->constrained();
            $table->string('static_salary');
            $table->string('uas_user_id')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
