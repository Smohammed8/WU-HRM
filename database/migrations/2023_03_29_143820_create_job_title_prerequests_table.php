<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitlePrerequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_title_prerequests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_title_id')->constrained('job_titles');
            $table->foreignId('job_prerequest_id')->constrained('job_titles');
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_title_prerequests');
    }
}
