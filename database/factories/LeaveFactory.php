<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\TypeOfLeave;
use App\Models\User;

class LeaveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Leave::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'type_of_leave_id' => TypeOfLeave::factory(),
            'created_by_id' => User::factory(),
            'approved_by_id' => User::factory(),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'description' => $this->faker->text,
        ];
    }
}
