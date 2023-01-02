<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EvaluationCategory;
use App\Models\EvalutionCreteria;

class EvalutionCreteriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EvalutionCreteria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'evaluation_category_id' => EvaluationCategory::factory(),
            'percent' => $this->faker->numberBetween(-10000, 10000),
            'name' => $this->faker->name,
        ];
    }
}
