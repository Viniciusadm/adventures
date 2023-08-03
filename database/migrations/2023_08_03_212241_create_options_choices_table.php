<?php

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
        Schema::create('options_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('adventure_id')->constrained();
            $table->foreignId('content_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options_choices');
    }
};
