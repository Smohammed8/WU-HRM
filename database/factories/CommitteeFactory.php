<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Committee;
use App\Models\PlacementRound;

class CommitteeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Committee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'round_id' => PlacementRound::factory(),
            'first_name' => $this->faker->firstName,
            'father_name' => $this->faker->word,
            'gender' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'role' => $this->faker->word,
        ];
    }
}
