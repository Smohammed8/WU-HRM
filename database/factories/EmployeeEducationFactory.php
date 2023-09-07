<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\FieldOfStudy;

class EmployeeEducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeEducation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'institution' => $this->faker->word,
            'field_of_study_id' => FieldOfStudy::factory(),
            'educational_level_id' => EducationalLevel::factory(),
            'training_start_date' => $this->faker->date(),
            'training_end_date' => $this->faker->date(),
            'upload' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
