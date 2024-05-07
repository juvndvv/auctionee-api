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
        $validStatus = $this->getValidStatus();

        Schema::create('auctions',
            function (Blueprint $table) use ($validStatus) {
            $table->string(Auction::UUID)->primary();
            $table->string(Auction::CATEGORY_UUID);
            $table->string(Auction::USER_UUID);
            $table->string(Auction::NAME);
            $table->string(Auction::DESCRIPTION);
            $table->enum(Auction::STATUS, $validStatus);
            $table->float(Auction::STARTING_PRICE);
            $table->timestamp(Auction::STARTING_DATE);
            $table->integer(Auction::DURATION);
            $table->string(Auction::AVATAR);
            $table->timestamps();

            $table->foreign(Auction::CATEGORY_UUID)->references(Category::UUID)->on('categories');

            $table->foreign(Auction::USER_UUID)->references(User::UUID)->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }

    public function getValidStatus(): array
    {
        $validStatus = [];

        foreach (Status::cases() as $case) {
            $validStatus[] = $case->name;
        }

        return $validStatus;
    }
};
