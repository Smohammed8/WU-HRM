<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PositionRequirement;
use App\Models\PositionType;
use App\Models\PositionValue;

class PositionValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PositionValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_type_id' => PositionType::factory(),
            'position_requirement_id' => PositionRequirement::factory(),
            'value' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
