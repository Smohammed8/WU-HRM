<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Nationality;

class NationalityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nationality::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nation' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'code' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'label' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
