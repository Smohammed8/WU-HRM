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
use App\Models\Template;
use App\Models\TemplateType;
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
        if (TemplateType::where('name', Constants::PROBATION_HIRE_LETTER)->count() == 0)
            TemplateType::create([
                'name' => Constants::PROBATION_HIRE_LETTER
            ]);
        $templateType = TemplateType::where('name', Constants::PROBATION_HIRE_LETTER)->first();
        if (Template::where('template_type_id', $templateType->id)->count() == 0)
            Template::create([
                'template_type_id' => $templateType->id,
                'body' => 'የጅማ ዩኒቨርሲቲ %unit% %posotion% የሥራ መደብ %employementType% ለመቅጠር በቀን %vacancyDate% ዓ/ም ባወጣው ማስታወቂያ መሠረት ተመዝግበው %examDate% ዓ.ም. በተሠጠው የጹሑፍ ፈተና እና በ %interviewDate% ዓ.ም. የተግባር ፈተና ወስደው እርስዎ ከተወዳዳሪዎች መካከል %totalmark% % ውጤት በማምጣት በ %employementType% እንዲቀጠሩ ተወስኗል፡፡

            በዚሁ መሰረት በደረጃ %jobLevel% በመደብ መታወቂያ ቁጥር %jobCode% በ %unit% በ%position% የሥራ መደብ ለስድስት ወር የሙከራ ጊዜ የተቀጠሩ መሆኑን እያስታወቅን በዚህ ጊዜ ውስጥ የተጣለብዎትን የስራ ኃላፊነት በትጋትና በታማኝነት እንዲወጡ እያሳሰብን ለሥራ መደቡ የተፈቀደው የወር ደመወዝ ብር %salary% /%salary_text% ብር/ እየተከፈልዎት እንዲሠሩ ተፈቅዷል::

            የክፍያና ሂሳብ አስተዳደር ዳይሬክቶሬትም ከ %hireDate% ዓ.ም. ጀምሮ ደመወዝዎን ከገንዘብና የኢኮኖሚ ልማት ትብብር ሚኒስቴር እየጠየቀ በማምጣት እንዲከፍልዎ በዚህ ደብዳቤ ግልባጭ እናሳስባለን፡፡'
            ]);
        // PositionRequirement::findOrCreate(Constants::EDUCATION_CRITERIA);
        // PositionRequirement::findOrCreate(Constants::EXPERIENCE_CRITERIA);
        Role::findOrCreate('super-admin');
        $user = User::where('username', 'super')->first();
        if ($user == null)
        if (User::count() == 0){
            // $user = User::create([
            //     'name' => 'Super Admin',
            //     'username' => 'super',
            //     'email' => 'super@hrm.com',
            //     'password' => Hash::make('1213/06'),
            // ]);
        
        $user->assignRole(Constants::USER_TYPE_SUPER_ADMIN);
        
        if (Organization::count() == 0)
            Organization::create([
                'name' => 'Jimma university',
                'email' => 'ero@ju.edu.et',
                'motto' => 'We are in the community!',
                'web_address' => 'www.ju.edu.et',
                'fax' => '+251-(0)47-443-0355',
                'telephone' => '+251-(0)47-443-0199',
                'pobox' => '213, Oromia, Ethiopia',
                'seal' => '',
            ]);
        $martialStatus = ['Divorce', 'Married', 'Single', 'Widow'];
        foreach ($martialStatus as $mStatus) {
            if (MaritalStatus::where('name', $mStatus)->count() == 0)
                MaritalStatus::create(['name' => $mStatus]);
        }
        if (Nationality::where('nation', 'Ethiopian[ኢትዮጵያዊ')->count() == 0)
            Nationality::create(['nation' => 'Ethiopian[ኢትዮጵያዊ', 'code' => 'ET[ኢት', 'label' => 'Ethiopia[ኢትዮጵያ']);
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
}