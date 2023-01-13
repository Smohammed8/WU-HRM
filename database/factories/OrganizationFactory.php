<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Models\UploadFile;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'mission' => $this->faker->text,
            'vision' => $this->faker->text,
            'motto' => $this->faker->text,
            'logo' => UploadFile::factory(),
            'web_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'fax' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'telephone' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'pobox' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'seal' => UploadFile::factory(),
            'president_signature' => UploadFile::factory(),
            'account_number' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'header' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'footer' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
