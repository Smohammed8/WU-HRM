<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Position;
use App\Models\Vacancy;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(["Internal","External"]),
            'registration_start_date' => $this->faker->date(),
            'registration_end_date' => $this->faker->date(),
            'position_id' => Position::factory(),
            'description' => $this->faker->text,
        ];
    }
}
