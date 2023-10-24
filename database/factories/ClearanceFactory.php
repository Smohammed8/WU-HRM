<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CheckPoint;
use App\Models\Clearance;
use App\Models\Employee;
use App\Models\User;

class ClearanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clearance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'check_point_id' => CheckPoint::factory(),
            'isApproved' => $this->faker->word,
            'approved_by' => User::factory(),
        ];
    }
}
