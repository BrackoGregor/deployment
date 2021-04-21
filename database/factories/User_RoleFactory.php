<?php

namespace Database\Factories;

use App\Models\User_Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class User_RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User_Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role' => $this->faker->colorName
        ];
    }
}
