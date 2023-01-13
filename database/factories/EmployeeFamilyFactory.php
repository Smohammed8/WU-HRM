<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeFamily;
use App\Models\FamilyRelationship;

class EmployeeFamilyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeFamily::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'family_relationship_id' => FamilyRelationship::factory(),
            'first_name' => $this->faker->firstName,
            'father_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'grand_father_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'gender' => $this->faker->randomElement(["Male","Female"]),
            'dob' => $this->faker->date(),
        ];
    }
}
