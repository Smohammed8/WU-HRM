<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeLanguage;
use App\Models\Language;

class EmployeeLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'language_id' => Language::factory(),
            'speaking' => $this->faker->randomElement(["Basic","Fair","Good","Fluent","Mather Taunt"]),
            'reading' => $this->faker->randomElement(["Excellent","Good","Fair","Poor","No"]),
            'writing' => $this->faker->randomElement(["Excellent","Good","Fair","Poor","No"]),
            'comment' => $this->faker->text,
        ];
    }
}
