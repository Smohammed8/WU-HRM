<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FieldOfStudy;
use App\Models\JobTitle;
use App\Models\JobTitleFieldOfStudy;

class JobTitleFieldOfStudyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobTitleFieldOfStudy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_title_id' => JobTitle::factory(),
            'field_of_study_id' => FieldOfStudy::factory(),
        ];
    }
}
