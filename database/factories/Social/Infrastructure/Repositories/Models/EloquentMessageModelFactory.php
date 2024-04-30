<?php

namespace Database\Factories\Social\Infrastructure\Repositories\Models;

use App\Social\Infrastructure\Repositories\Models\EloquentChatRoomModel;
use App\Social\Infrastructure\Repositories\Models\EloquentMessageModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EloquentMessageModelFactory extends Factory
{
    protected $model = EloquentMessageModel::class;

    public function definition(): array
    {
        $chatRoomUuid = EloquentChatRoomModel::all()->random()->uuid;
        return [
            'uuid' => $this->faker->uuid(),
            'chat_room_uuid' => $chatRoomUuid,
            'sender_uuid' => EloquentChatRoomModel::query()->where('chat_rooms.uuid', '=', $chatRoomUuid)->first()->left_uuid,
            'content' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
