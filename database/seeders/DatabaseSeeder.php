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
            User::UUID => 'U0000000-0000-0000-0000-000000000000',
            User::NAME => 'Auctionee Main Account',
            User::USERNAME => 'admin',
            User::EMAIL => 'admin@jotade.dev',
            User::AVATAR => env('DEFAULT_AVATAR'),
            User::PASSWORD => 'admin',
            User::BIRTH => '1990-01-01',
            User::ROLE => User::ADMIN_ROLE,
        ]);

        DB::table('wallets')->insert([
            Wallet::UUID => 'W0000000-0000-0000-0000-000000000000',
            Wallet::BALANCE => 9999999,
            Wallet::USER_UUID => 'U0000000-0000-0000-0000-000000000000',
        ]);

        DB::table('users')->insert([
            User::UUID => 'UD000000-0000-0000-0000-000000000000',
            User::NAME => 'Deleted Account',
            User::USERNAME => 'deleted',
            User::EMAIL => 'deleted@jotade.dev',
            User::AVATAR => env('DEFAULT_AVATAR'),
            User::PASSWORD => 'deleted',
            User::BIRTH => '1990-01-01',
            User::ROLE => User::USER_ROLE,
        ]);

        DB::table('wallets')->insert([
            Wallet::UUID => 'WD000000-0000-0000-0000-000000000000',
            Wallet::BALANCE => 0,
            Wallet::USER_UUID => 'UD0000000-0000-0000-0000-000000000000',
        ]);

        /**
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
         **/
    }
}
