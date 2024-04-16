<?php

namespace Database\Seeders;

use App\auction\infra\Repositories\Models\EloquentAuctionModel;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // EloquentUserModel::factory(10)->create();

        /*
        EloquentUserModel::factory()->create([
            'name' => 'Test EloquentUserModel',
            'email' => 'test@example.com',
        ]);
        */

        EloquentAuctionModel::factory(10)->create();
    }
}
