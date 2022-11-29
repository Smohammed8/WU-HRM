<?php

use App\Models\EducationalLevel;
use App\Models\EmployeeCategory;
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
            $table->enum('gender', ["Male","Female"])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('photo')->nullable();
            $table->string('birth_city', 255)->nullable();
            $table->string('passport', 255)->nullable();
            $table->string('driving_licence')->nullable();
            $table->enum('blood_group', ["A","B","AB","O"])->nullable();
            $table->enum('eye_color', ["Amber","Blue","Brown","Gray","Green","Hazel","Red"])->nullable();
            $table->string('phone_number', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('rfid', 100)->nullable();
            $table->string('employment_identity')->nullable();
            $table->foreignIdFor(EducationalLevel::class);
            $table->foreignId('marital_status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ethnicity_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('religion_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('unit_id')->nullable()->constrained('units')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('level_id')->nullable()->constrained('levels')->onUpdate('cascade')->onDelete('cascade');
            $table->date('employement_date')->nullable();
            $table->foreignId('position_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('employment_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('pention_number')->nullable();
            $table->foreignId('employment_status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('nationality_id')->nullable()->constrained('nationalities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('uas_user_id')->foreignId('user_id')->constrained()->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
        /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        Schema::dropIfExists('employees');

    }

}
