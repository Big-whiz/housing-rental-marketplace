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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            
            // Link to the user who favorited the listing (tenant)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Link to the listing that was favorited
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Prevent duplicate favorites by the same user for the same listing
            $table->unique(['user_id', 'listing_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
