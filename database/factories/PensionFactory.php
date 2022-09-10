<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EmployeeCategory;
use App\Models\Pension;

class PensionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pension::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(["Male","Female"]),
            'year' => $this->faker->numberBetween(-10000, 10000),
            'extend_year' => $this->faker->numberBetween(-10000, 10000),
            'employee_category_id' => EmployeeCategory::factory(),
        ];
    }
}
