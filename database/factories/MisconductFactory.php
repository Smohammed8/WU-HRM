<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Misconduct;
use App\Models\TypeOfMisconduct;
use App\Models\User;

class MisconductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Misconduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'type_of_misconduct_id' => TypeOfMisconduct::factory(),
            'created_by_id' => User::factory(),
            'attachement' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'action_taken' => $this->faker->text,
            'serverity' => $this->faker->randomElement(["High","Medium","Low"]),
            'description' => $this->faker->text,
        ];
    }
}
