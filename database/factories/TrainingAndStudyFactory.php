<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\Nationality;
use App\Models\TrainingAndStudy;

class TrainingAndStudyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingAndStudy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'name' => $this->faker->name,
            'nationality_id' => Nationality::factory(),
            'educational_level_id' => EducationalLevel::factory(),
            'inistitution' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'city' => $this->faker->city,
            'is_contract' => $this->faker->boolean,
            'date_of_leave' => $this->faker->date(),
            'end_of_study' => $this->faker->date(),
        ];
    }
}
