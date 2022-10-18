<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\NewJobTitle;
use App\Models\OldJobTitle;
use App\Models\Promotion;
use App\Models\Unit;
use App\Models\User;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'old_unit_id' => Unit::factory(),
            'new_unit_id' => Unit::factory(),
            'old_job_title_id' => OldJobTitle::factory(),
            'new_job_title_id' => NewJobTitle::factory(),
            'created_by_id' => User::factory(),
            'reason_of_promotion' => $this->faker->text,
        ];
    }
}
