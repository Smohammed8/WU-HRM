<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\EmployeeEvaluation;
use App\Models\EvaluationLevel;
use App\Models\EvalutionCreterium;

class EmployeeEvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeEvaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'evalution_creteria_id' => EvalutionCreterium::factory(),
            'evaluation_level_id' => EvaluationLevel::factory(),
        ];
    }
}
