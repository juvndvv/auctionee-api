<?php

namespace Database\Factories\User\Infrastructure\Repositories\Models;

use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EloquentUserModelFactory extends Factory
{
    protected $model = EloquentUserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(gender: 'male'),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
            'avatar' => env('DEFAULT_AVATAR'),
            'birth' => $this->faker->date(),
            'role' => '0'
        ];
    }
}
