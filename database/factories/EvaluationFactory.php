<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\Quarter;
use App\Models\User;

class EvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'quarter_id' => Quarter::factory(),
            'total_mark' => $this->faker->numberBetween(-10000, 10000),
            'created_by_id' => User::factory(),
        ];
    }
}
