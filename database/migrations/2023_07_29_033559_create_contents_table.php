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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adventure_id')->constrained()->onDelete('cascade');
            $table->foreignId('next_content_id')->nullable()->constrained('contents')->onDelete('cascade');
            $table->boolean('has_options')->default(false);
            $table->longText('body');
            $table->enum('type', ['narrator', 'self', 'character']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
