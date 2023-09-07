<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CollegePositionCode;
use App\Models\HrBranch;

class CollegePositionCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CollegePositionCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'college' => HrBranch::factory(),
            'prefix' => $this->faker->word,
            'start' => $this->faker->numberBetween(-10000, 10000),
            'description' => $this->faker->text,
        ];
    }
}
