<?php

use App\Auction\Domain\Models\Auction\Auction;
use App\Auction\Domain\Models\Auction\ValueObjects\Status;
use App\Auction\Domain\Models\Category\Category;
use App\User\Domain\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get valids status
        $validStatus = [];

        foreach (Status::cases() as $case) {
            $validStatus[] = $case->name;
        }

        Schema::create('auctions',
            function (Blueprint $table) use ($validStatus) {
            $table->string(Auction::SERIALIZED_UUID)->primary();
            $table->string(Auction::SERIALIZED_CATEGORY_UUID);
            $table->string(Auction::SERIALIZED_USER_UUID);
            $table->string(Auction::SERIALIZED_NAME);
            $table->string(Auction::SERIALIZED_DESCRIPTION);
            $table->enum(Auction::SERIALIZED_STATUS, $validStatus);
            $table->float(Auction::SERIALIZED_STARTING_PRICE);
            $table->timestamp(Auction::SERIALIZED_STARTING_DATE);
            $table->integer(Auction::SERIALIZED_DURATION);
            $table->timestamps();

            $table->foreign(Auction::SERIALIZED_CATEGORY_UUID)->references(Category::SERIALIZED_UUID)->on('categories');

            $table->foreign(Auction::SERIALIZED_USER_UUID)->references(User::SERIALIZED_UUID)->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
