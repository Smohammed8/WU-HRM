<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ExperienceComparisonCriteria;
use App\Models\PositionValue;

class ExperienceComparisonCriteriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExperienceComparisonCriteria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_value_id' => PositionValue::factory(),
            'title' => $this->faker->sentence(4),
            'min_year' => $this->faker->numberBetween(-10000, 10000),
            'max_year' => $this->faker->numberBetween(-10000, 10000),
            'value' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
