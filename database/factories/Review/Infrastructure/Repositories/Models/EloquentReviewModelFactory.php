<?php

namespace Database\Factories\Review\Infrastructure\Repositories\Models;

use App\Review\Infrastructure\Repositories\Models\EloquentReviewModel;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EloquentReviewModelFactory extends Factory
{
    protected $model = EloquentReviewModel::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'reviewer_uuid' => EloquentUserModel::all()->random()->uuid,
            'reviewed_uuid' => EloquentUserModel::all()->random()->uuid,
            'description' => $this->faker->realText(),
            'rating' => $this->faker->numberBetween(1,5),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
