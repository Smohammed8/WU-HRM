<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\JobTitle;
use App\Models\MinimumRequirement;
use App\Models\RelatedWork;

class RelatedWorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RelatedWork::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'minimum_requirement_id' => MinimumRequirement::factory(),
            'job_title_id' => JobTitle::factory(),
        ];
    }
}
