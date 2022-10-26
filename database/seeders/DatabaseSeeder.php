<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\Ethnicity;
use App\Models\JobTitle;
use App\Models\JobTitleCategory;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\Region;
use App\Models\Religion;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // MaritalStatus::factory(4)->create();
        // $nationality = Nationality::create(['nation'=>'Ethiopian','code'=>'ET','label'=>'Ethiopia']);
        // $region = Region::create(['name'=>'Oroomia','nationality_id'=>$nationality->id]);
        // $ethnicity = Ethnicity::create(['name'=>'Oromo','region_id'=>$region->id]);
        // $isReligion = Religion::create(['name'=>'Islam']);
        // $chReligion = Religion::create(['name'=>'Christian']);
        // Unit::factory(1)->create();
        // $jobCategory = JobTitleCategory::create(['name'=>"IT",'unit_id'=>1]);
        // $jobTitle = JobTitle::create(['name'=>'Software Developer','job_title_category_id'=>$jobCategory->id]);
        // $employementType = EmploymentType::create(['name'=>'Permanent']);
        // $employmentStatus = EmploymentStatus::create(['name'=>'Working']);
    }
}
