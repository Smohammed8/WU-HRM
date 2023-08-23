<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Complaint;
use App\Models\Employee;
use App\Models\Unit;

class ComplaintFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Complaint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'unit_id' => Unit::factory(),
            'phone' => $this->faker->phoneNumber,
            'complian_message' => $this->faker->text,
            'isReviewed' => $this->faker->word,
        ];
    }
}
