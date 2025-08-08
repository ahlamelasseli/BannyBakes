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
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('status'); // pending, processing, packed, shipped, delivered
            $table->text('message')->nullable(); // Custom message for this status update
            $table->string('location')->nullable(); // Current location (for shipping)
            $table->timestamp('status_date'); // When this status was set
            $table->foreignId('updated_by')->nullable()->constrained('users'); // Admin who updated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};
