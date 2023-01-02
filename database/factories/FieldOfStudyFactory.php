<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EducationalLevel;
use App\Models\FieldOfStudy;

class FieldOfStudyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FieldOfStudy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'educational_level_id' => EducationalLevel::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
