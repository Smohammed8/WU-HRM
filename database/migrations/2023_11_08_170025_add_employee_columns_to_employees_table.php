<?php

use App\Models\Kebele;
use App\Models\Region;
use App\Models\Woreda;
use App\Models\Zone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeColumnsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
        $table->foreignIdFor(Region::class,'region_id')->nullable()->constrained();
        $table->foreignIdFor(Zone::class,'zone_id')->nullable()->constrained();
        $table->foreignIdFor(Woreda::class,'woreda_id')->nullable()->constrained();
    
        });
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
