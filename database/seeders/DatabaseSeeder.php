<?php

namespace Database\Seeders;

use App\Financial\Domain\Models\Wallet;
use App\Review\Infrastructure\Repositories\Models\EloquentReviewModel;
use App\Social\Infrastructure\Repositories\Models\EloquentChatRoomModel;
use App\Social\Infrastructure\Repositories\Models\EloquentMessageModel;
use App\User\Domain\Models\User;
use App\User\Infrastructure\Repositories\Models\EloquentUserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default users
        DB::table('users')->insert([
            User::SERIALIZED_UUID => 'U0000000-0000-0000-0000-000000000000',
            User::SERIALIZED_NAME => 'Auctionee Main Account',
            User::SERIALIZED_USERNAME => 'admin',
            User::SERIALIZED_EMAIL => 'admin@jotade.dev',
            User::SERIALIZED_AVATAR => env('DEFAULT_AVATAR'),
            User::SERIALIZED_PASSWORD => 'admin',
            User::SERIALIZED_BIRTH => '1990-01-01',
            User::SERIALIZED_ROLE => User::ADMIN_ROLE,
        ]);

        DB::table('wallets')->insert([
            Wallet::SERIALIZED_UUID => 'W0000000-0000-0000-0000-000000000000',
            Wallet::SERIALIZED_AMOUNT => 0,
            Wallet::SERIALIZED_USER_UUID => 'U0000000-0000-0000-0000-000000000000',
        ]);

        DB::table('users')->insert([
            User::SERIALIZED_UUID => 'UD000000-0000-0000-0000-000000000000',
            User::SERIALIZED_NAME => 'Deleted Account',
            User::SERIALIZED_USERNAME => 'deleted',
            User::SERIALIZED_EMAIL => 'deleted@jotade.dev',
            User::SERIALIZED_AVATAR => env('DEFAULT_AVATAR'),
            User::SERIALIZED_PASSWORD => 'deleted',
            User::SERIALIZED_BIRTH => '1990-01-01',
            User::SERIALIZED_ROLE => User::USER_ROLE,
        ]);

        DB::table('wallets')->insert([
            Wallet::SERIALIZED_UUID => 'WD000000-0000-0000-0000-000000000000',
            Wallet::SERIALIZED_AMOUNT => 0,
            Wallet::SERIALIZED_USER_UUID => 'UD0000000-0000-0000-0000-000000000000',
        ]);

        EloquentUserModel::factory()->count(1000)->create();

        EloquentUserModel::all()->each(function ($user) {
            DB::table('wallets')->insert([
                'uuid' => $user->uuid,
                'amount' => 10000,
                'user_uuid' => $user->uuid,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        });

        EloquentChatRoomModel::factory()->count(200)->create();
        EloquentMessageModel::factory()->count(300)->create();
        EloquentReviewModel::factory()->count(400)->create();
    }
}
