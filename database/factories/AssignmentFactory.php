<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'work_description' => $this->faker->text(100),
            'developer_description' => $this->faker->text(100),
            'id_clients' => Client::all()->random()->id,
            'id_statuses' => Status::all()->random()->id
        ];
    }
}
