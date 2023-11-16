<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EmployeeCategory;
use App\Models\EmployeeSubCategory;

class EmployeeSubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeSubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'employee_category_id' => EmployeeCategory::factory(),
            'description' => $this->faker->text,
        ];
    }
}
