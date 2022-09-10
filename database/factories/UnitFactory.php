<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Models\Unit;
use App\Models\UploadFile;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'acronym' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'email' => $this->faker->safeEmail,
            'telephone' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'extension_line' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'location' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'seal' => UploadFile::factory(),
            'teter' => UploadFile::factory(),
            'vision' => $this->faker->text,
            'mission' => $this->faker->text,
            'objective' => $this->faker->text,
            'building_number' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'office_number' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'motto' => $this->faker->text,
            'value_list' => $this->faker->text,
            'parent_unit_id' => Unit::factory(),
            'reports_to_id' => Unit::factory(),
            'organization_id' => Organization::factory(),
            'chair_man_type_id' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
