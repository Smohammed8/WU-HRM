<?php

use App\Models\EmployeeSubCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSubCategoryIdToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('employees', function (Blueprint $table) {
            $table->foreignIdFor(EmployeeSubCategory::class,'employee_sub_category_id')->nullable()->constrained();
            });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_sub_category_id_to_employees');
    }
}
