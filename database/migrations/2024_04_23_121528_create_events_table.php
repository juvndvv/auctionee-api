<?php

use App\Retention\EventMonitoring\Domain\Models\Event;
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
        Schema::create('events', function (Blueprint $table) {
            $table->string(Event::SERIALIZED_UUID)->primary();
            $table->string(Event::SERIALIZED_TYPE);
            $table->json(Event::SERIALIZED_PAYLOAD);
            $table->timestamp(Event::SERIALIZED_OCCURRED_ON);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
