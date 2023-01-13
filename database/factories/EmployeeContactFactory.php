<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeContact;

class EmployeeContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'contact_type' => $this->faker->randomElement(["Emergency","Other"]),
            'contact_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'contact' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
