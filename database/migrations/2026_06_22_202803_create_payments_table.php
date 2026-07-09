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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Link to the user who paid
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Link to the listing they paid for (e.g. deposit or viewing fee)
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('transaction_reference')->nullable(); // external gateway transaction ID
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
