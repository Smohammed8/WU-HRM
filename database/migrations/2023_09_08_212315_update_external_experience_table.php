<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\EmploymentType;

class UpdateExternalExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_experiences', function (Blueprint $table) {

        $table->foreignIdFor(EmploymentType::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

    });
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
