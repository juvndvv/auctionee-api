<?php

use App\Auction\Domain\Models\Category\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->string(Category::UUID)->primary();
            $table->string(Category::NAME)->unique();
            $table->string(Category::DESCRIPTION);
            $table->string(Category::AVATAR);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
