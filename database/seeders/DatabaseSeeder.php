<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\Ethnicity;
use App\Models\JobTitle;
use App\Models\JobTitleCategory;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\Organization;
use App\Models\PositionRequirement;
use App\Models\Region;
use App\Models\Religion;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            // TestDataSeeder::class,
        ]);
        // PositionRequirement::findOrCreate(Constants::EDUCATION_CRITERIA);
        // PositionRequirement::findOrCreate(Constants::EXPERIENCE_CRITERIA);
        Role::findOrCreate('super-admin');
        $user = User::where('username', 'super')->first();
        if ($user == null)
            $user = User::create([
                'name' => 'Super Admin',
                'username' => 'super',
                'email' => 'super@hrm.com',
                'password' => Hash::make('password'),
            ]);
        $user->assignRole(Constants::USER_TYPE_SUPER_ADMIN);
        if (Organization::count() == 0)
            Organization::create([
                'name' => 'Bule Hoara university',
                'email' => 'ero@bhu.edu.et',
                'motto' => 'Jijjiiramaa Fula\'aaf Hojjanna!',
                'web_address' => 'www.bhu.edu.et',
                'fax' => '+251-(0)46-443-0355',
                'telephone' => '+251-(0)46-443-0199',
                'pobox' => '144, Oromia, Ethiopia',
                'seal' => '',
            ]);
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
