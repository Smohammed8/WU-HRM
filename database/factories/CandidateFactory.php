<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Candidate;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\FieldOfStudy;
use App\Models\Nationality;
use App\Models\Vacancy;

class CandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vacancy_id' => Vacancy::factory(),
            'employee_id' => Employee::factory(),
            'first_name' => $this->faker->firstName,
            'father_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'grand_father_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'dob' => $this->faker->date(),
            'field_of_study_id' => FieldOfStudy::factory(),
            'educational_level_id' => EducationalLevel::factory(),
            'gpa' => $this->faker->randomFloat(0, 0, 9999999999.),
            'gender' => $this->faker->randomElement(["Male","Female"]),
            'disablity_status' => $this->faker->word,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'year_of_graduation' => $this->faker->numberBetween(-10000, 10000),
            'nationality_id' => Nationality::factory(),
            'total_experience' => $this->faker->numberBetween(-10000, 10000),
            'job_position_experience' => $this->faker->numberBetween(-10000, 10000),
            'mark' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
