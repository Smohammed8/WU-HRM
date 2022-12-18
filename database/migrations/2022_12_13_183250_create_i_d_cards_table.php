<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIDCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_d_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('front_page')->nullable();
            $table->string('back_page')->nullable();
            $table->string('seal')->nullable();
            $table->string('signature')->nullable();
            $table->text('front_page_tab')->nullable();
            $table->text('back_page_tab')->nullable();
            $table->text('front_page_template')->nullable();
            $table->text('back_page_template')->nullable();
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
        Schema::dropIfExists('i_d_cards');
    }
}
