<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\JobGrade;
use App\Models\Level;

class JobGradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobGrade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'level_id' => Level::factory(),
            'start_salary' => $this->faker->word,
            'one' => $this->faker->word,
            'two' => $this->faker->word,
            'three' => $this->faker->word,
            'four' => $this->faker->word,
            'five' => $this->faker->word,
            'six' => $this->faker->word,
            'seven' => $this->faker->word,
            'eight' => $this->faker->word,
            'nine' => $this->faker->word,
            'ceil_salary' => $this->faker->word,
        ];
    }
}
