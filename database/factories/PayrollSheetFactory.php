<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payroll;
use App\Models\PayrollSheet;
use App\Models\User;

class PayrollSheetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayrollSheet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payroll_id' => Payroll::factory(),
            'sheet_code' => $this->faker->word,
            'year' => $this->faker->numberBetween(-10000, 10000),
            'month' => $this->faker->numberBetween(-10000, 10000),
            'user_id' => User::factory(),
            'created_at' => $this->faker->date(),
        ];
    }
}
