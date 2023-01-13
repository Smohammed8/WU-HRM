<?php

namespace Database\Factories;

use App\Models\EducationalLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\Ethnicity;
use App\Models\JobTitle;
use App\Models\MaritalStatus;
use App\Models\Position;
use App\Models\Religion;
use App\Models\Unit;
use App\Models\UploadFile;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'father_name' => $this->faker->firstName,
            'grand_father_name' => $this->faker->firstName,
            'gender' => $this->faker->randomElement(["Male","Female"]),
            'date_of_birth' => $this->faker->date(),
            'educational_level_id' => $this->faker->numberBetween(1,EducationalLevel::count()),
            'position_id' => $this->faker->numberBetween(1,Position::count()),
            'employement_date' => $this->faker->dateTimeBetween('-30 years','now'),
            // 'photo' => UploadFile::factory(),
            // 'birth_city' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            // 'passport' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            // 'driving_licence' => UploadFile::factory(),
            // 'blood_group' => $this->faker->randomElement(["A","B","AB","O"]),
            // 'eye_color' => $this->faker->randomElement(["Amber","Blue","Brown","Gray","Green","Hazel","Red"]),
            // 'phone_number' => $this->faker->phoneNumber,
            // 'alternate_email' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            // 'rfid' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            // 'employment_identity' => $this->faker->numberBetween(-10000, 10000),
            // 'marital_status_id' => MaritalStatus::factory(),
            // 'ethnicity_id' => Ethnicity::factory(),
            // 'religion_id' => Religion::factory(),
            // 'unit_id' => Unit::factory(),
            // 'salary_step' => $this->faker->randomElement(["Base","I","II","III","IV","V","Vi","VII","VIII","IX","Celing"]),
            // 'job_title_id' => JobTitle::factory(),
            // 'employment_type_id' => EmploymentType::factory(),
            // 'pention_number' => $this->faker->numberBetween(-10000, 10000),
            // 'employment_status_id' => EmploymentStatus::factory(),
            // 'static_salary' => $this->faker->word,
            // 'uas_user_id' => $this->faker->word,
        ];
    }
}
