<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->foreignId('job_title_category_id')->constrained();

            $table->integer('vacant_post')->nullable()->nullable();
            $table->foreignId('level_id')->constrained('levels')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('educational_level_id')->constrained('educational_levels')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('field_of_study_id')->constrained('field_of_studies')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('unit_id')->constrained('units')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->string('job_code', 100)->nullable();
            $table->float('work_experience')->nullable();
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
        Schema::dropIfExists('job_titles');
    }
}
