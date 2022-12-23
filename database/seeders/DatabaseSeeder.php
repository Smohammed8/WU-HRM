<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\Employee;
use App\Models\EmployeeCategory;
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
        $martialStatus = ['Divorce', 'Married', 'Single', 'Widow'];
        foreach ($martialStatus as $mStatus) {
            if (MaritalStatus::where('name', $mStatus)->count() == 0)
                MaritalStatus::create(['name' => $mStatus]);
        }
        if (Nationality::where('nation', 'Ethiopian')->count() == 0)
            Nationality::create(['nation' => 'Ethiopian', 'code' => 'ET', 'label' => 'Ethiopia']);
        if (EmployeeCategory::where('name', 'Administrative Staff')->count() == 0)
            EmployeeCategory::create(['name' => 'Administrative Staff']);
        if (EmployeeCategory::where('name', 'Academic Staff')->count() == 0)
            EmployeeCategory::create(['name' => 'Academic Staff']);
        if (EmploymentType::where('name', 'Permanent')->count() == 0)
            EmploymentType::create(['name' => 'Permanent']);
        if (EmploymentStatus::where('name', 'Working')->count() == 0)
            EmploymentStatus::create(['name' => 'Working']);
    }
}
