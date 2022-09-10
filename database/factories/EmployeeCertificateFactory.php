<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeCertificate;
use App\Models\SkillType;

class EmployeeCertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeCertificate::class;

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
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'certificate_date' => $this->faker->date(),
            'duration' => $this->faker->numberBetween(-10000, 10000),
            'comment' => $this->faker->text,
        ];
    }
}
