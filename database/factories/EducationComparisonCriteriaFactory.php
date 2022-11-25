<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EducationComparisonCriteria;
use App\Models\EducationalLevel;
use App\Models\MinEducationalLevel;
use App\Models\PositionValue;

class EducationComparisonCriteriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EducationComparisonCriteria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_value_id' => PositionValue::factory(),
            'educational_level_id' => EducationalLevel::factory(),
            'min_educational_level_id' => MinEducationalLevel::factory(),
            'value' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
