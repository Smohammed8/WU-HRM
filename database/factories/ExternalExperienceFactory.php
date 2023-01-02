<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\ExternalExperience;
use App\Models\Unit;

class ExternalExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExternalExperience::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'unit_id' => Unit::factory(),
            'job_title' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'company_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'comment' => $this->faker->text,
        ];
    }
}
