<?php

namespace Database\Seeders;

use App\Financial\Domain\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Financial\Domain\Models\Wallet;
use App\UserManagement\Domain\Models\User;
use Illuminate\Database\Seeder;

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

        // Testing purposes
        DB::table('users')->insert([
            USER::SERIALIZED_UUID => '5bfdc240-1780-423a-9688-fd9c50d2d661',
            User::SERIALIZED_NAME => 'Juan Daniel Forner',
            User::SERIALIZED_USERNAME => 'juvndv',
            User::SERIALIZED_EMAIL => 'jd@jotade.dev',
            User::SERIALIZED_AVATAR => env('DEFAULT_AVATAR'),
            User::SERIALIZED_PASSWORD => 'jaja',
            User::SERIALIZED_BIRTH => '1990-01-01',
            User::SERIALIZED_ROLE => User::USER_ROLE
        ]);

        DB::table('wallets')->insert([
            Wallet::SERIALIZED_UUID => 'f17fab00-fb9e-4e03-b393-60e1f1b9932f',
            Wallet::SERIALIZED_AMOUNT => 0,
            Wallet::SERIALIZED_USER_UUID => '5bfdc240-1780-423a-9688-fd9c50d2d661',
        ]);

        DB::table('users')->insert([
            USER::SERIALIZED_UUID => 'c0ba5e6c-461f-42b0-a568-3fe93e144811',
            User::SERIALIZED_NAME => 'Jose Domingas',
            User::SERIALIZED_USERNAME => 'jdfs',
            User::SERIALIZED_EMAIL => 'jdfs@jotade.dev',
            User::SERIALIZED_AVATAR => env('DEFAULT_AVATAR'),
            User::SERIALIZED_PASSWORD => 'jaja',
            User::SERIALIZED_BIRTH => '1990-01-01',
            User::SERIALIZED_ROLE => User::USER_ROLE
        ]);

        DB::table('wallets')->insert([
            Wallet::SERIALIZED_UUID => '668430b8-f7c6-42d1-a74d-6c8a2505ad1d',
            Wallet::SERIALIZED_AMOUNT => 0,
            Wallet::SERIALIZED_USER_UUID => 'c0ba5e6c-461f-42b0-a568-3fe93e144811',
        ]);

        DB::table('transactions')->insert([
            Transaction::SERIALIZED_UUID => '4cc6916c-e3d9-41c9-87b0-e438a2e7d04c',
            Transaction::SERIALIZED_DESTINATION_WALLET_UUID => 'f17fab00-fb9e-4e03-b393-60e1f1b9932f',
            Transaction::SERIALIZED_REMITTENT_WALLET_UUID => '668430b8-f7c6-42d1-a74d-6c8a2505ad1d',
            Transaction::SERIALIZED_AMOUNT => 10,
        ]);

        DB::table('transactions')->insert([
            Transaction::SERIALIZED_UUID => '066d43f7-db37-4a4c-b7e4-cea6d8dede41',
            Transaction::SERIALIZED_DESTINATION_WALLET_UUID => 'f17fab00-fb9e-4e03-b393-60e1f1b9932f',
            Transaction::SERIALIZED_REMITTENT_WALLET_UUID => '668430b8-f7c6-42d1-a74d-6c8a2505ad1d',
            Transaction::SERIALIZED_AMOUNT => 200,
        ]);
    }
}
