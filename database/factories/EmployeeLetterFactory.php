<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeLetter;

class EmployeeLetterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeLetter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->text,
            'written_date' => $this->faker->date(),
            'upload' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
