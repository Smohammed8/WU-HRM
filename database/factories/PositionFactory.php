<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\JobTitle;
use App\Models\Position;
use App\Models\Unit;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_id' => Unit::factory(),
            'job_title_id' => JobTitle::factory(),
            'total_employees' => $this->faker->numberBetween(-10000, 10000),
            'available_for_placement' => $this->faker->word,
            'status' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
