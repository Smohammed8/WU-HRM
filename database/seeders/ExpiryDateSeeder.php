<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\ExpiryDate;
use Illuminate\Database\Seeder;

class ExpiryDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (EmployeeCategory::all() as $key => $value) {
            if ($value->name == 'Student') {
                ExpiryDate::create(['employee_category_id'=>$value->id, 'value'=>'2']);
            } else {
                ExpiryDate::create(['employee_category_id'=>$value->id, 'value'=>'5']);
            }
        }
    }
}
