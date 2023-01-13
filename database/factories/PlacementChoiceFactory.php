<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;

class PlacementChoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlacementChoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'placement_round_id' => PlacementRound::factory(),
            'employee_id' => Employee::factory(),
            'choice_one_id' => Position::factory(),
            'choice_two_id' => Position::factory(),
        ];
    }
}
