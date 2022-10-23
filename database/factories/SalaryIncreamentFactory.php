<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Salary_increament;
use App\Models\User;

class SalaryIncreamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryIncreament::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'percentage' => $this->faker->numberBetween(-10000, 10000),
            'created_by_id' => User::factory(),
        ];
    }
}
