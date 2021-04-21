<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'start_time' => '2021-04-08 11:30:25',
            'end_time' => '2021-04-08 11:30:25',
            'comment' => $this->faker->text(200),
            'id_assignments' => Assignment::all()->random()->id
        ];
    }
}
