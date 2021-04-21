<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\User;
use App\Models\User_Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User_Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_users' => User::all()->random()->id,
            'id_assignments' => Assignment::all()->random()->id
        ];
    }
}
