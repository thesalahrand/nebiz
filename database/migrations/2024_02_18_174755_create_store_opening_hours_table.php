<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_opening_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained();
            $table->unsignedTinyInteger('day_of_week');
            $table->boolean('is_closed');
            $table->string('opens_at', 5)->nullable();
            $table->string('closes_at', 5)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_opening_hours');
    }
};
