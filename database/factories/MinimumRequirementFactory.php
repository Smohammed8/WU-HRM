<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EducationalLevel;
use App\Models\MinimumRequirement;
use App\Models\Position;

class MinimumRequirementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MinimumRequirement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_id' => Position::factory(),
            'experience' => $this->faker->numberBetween(-10000, 10000),
            'educational_level_id' => EducationalLevel::factory(),
            'minimum_efficeny' => $this->faker->randomFloat(0, 0, 9999999999.),
            'minimum_employee_profile_value' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
