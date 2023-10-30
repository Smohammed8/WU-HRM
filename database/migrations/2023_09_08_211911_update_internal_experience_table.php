<?php

use App\Models\EmploymentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInternalExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('internal_experiences', function (Blueprint $table) {
         
            // $table->foreignId('employment_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
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
