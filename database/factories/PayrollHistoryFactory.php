<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PayrollHistory;
use App\Models\PayrollSheet;

class PayrollHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayrollHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sheet_id' => PayrollSheet::factory(),
            'total_paid' => $this->faker->word,
            'created_at' => $this->faker->date(),
        ];
    }
}
