<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('email', 255)->unique();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('motto')->nullable();
            $table->string('logo')->nullable();
            $table->string('web_address', 255)->unique()->nullable();
            $table->string('fax', 100)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('pobox', 100)->nullable();
            $table->string('seal')->nullable();
            $table->string('president_signature')->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('header', 255)->nullable();
            $table->string('footer', 255)->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
