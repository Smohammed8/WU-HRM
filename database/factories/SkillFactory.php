<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Skill;
use App\Models\SkillType;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'skill_type_id' => SkillType::factory(),
            'name' => $this->faker->name,
            'level' => $this->faker->numberBetween(-10000, 10000),
            'description' => $this->faker->text,
        ];
    }
}
