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
            User::NAME => 'Entidad bancaria',
            User::USERNAME => 'banca',
            User::EMAIL => 'banca@jotade.dev',
            User::AVATAR => env('DEFAULT_AVATAR'),
            User::PASSWORD => 'banca',
            User::BIRTH => '1990-01-01',
            User::ROLE => User::ADMIN_ROLE,
        ]);

        DB::table('wallets')->insert([
            Wallet::UUID => 'U0000000-0000-0000-0000-000000000000',
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
            Wallet::UUID => 'UD000000-0000-0000-0000-000000000000',
            Wallet::BALANCE => 0,
            Wallet::USER_UUID => 'UD0000000-0000-0000-0000-000000000000',
        ]);
    }
}
