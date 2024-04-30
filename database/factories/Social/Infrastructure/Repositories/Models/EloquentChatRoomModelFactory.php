<?php

namespace Database\Factories\Social\Infrastructure\Repositories\Models;

use App\Social\Infrastructure\Repositories\Models\EloquentChatRoomModel;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Factories\Factory;


class EloquentChatRoomModelFactory extends Factory
{
    protected $model = EloquentChatRoomModel::class;
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'left_uuid' => EloquentUserModel::all()->random()->uuid,
            'right_uuid' => EloquentUserModel::all()->random()->uuid,
            'created_at' => $this->faker->dateTimeBetween('-1 years'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years')
        ];
    }
}
