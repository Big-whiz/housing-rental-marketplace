<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create the listings table.
     */
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id(); // Standard auto-increment primary key
            
            // Link to the user who posted the listing (landlord)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2); // 10 digits total, 2 after decimal
            $table->string('property_type'); // e.g., Apartment, House, Room
            $table->integer('bedrooms');
            
            // Location information
            $table->string('location'); // General neighborhood/district name
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            // Photos stored as a simple JSON array of URLs (max 3 images)
            $table->json('photos')->nullable();
            
            // Verification toggle (approved by admin)
            $table->boolean('is_verified')->default(false);
            
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
