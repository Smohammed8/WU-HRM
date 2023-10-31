<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Notice;
use App\Models\NoticeType;
use App\Models\User;

class NoticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'notice_type_id' => NoticeType::factory(),
            'body' => $this->faker->text,
            'visitor_count' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
