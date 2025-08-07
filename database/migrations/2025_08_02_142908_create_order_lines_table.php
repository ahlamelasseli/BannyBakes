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
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Links to orders table
            $table->foreignId('cookie_id')->constrained()->onDelete('cascade'); // Links to cookies table
            $table->string('cookie_name'); // Store cookie name at time of order
            $table->integer('quantity'); // How many of this cookie
            $table->decimal('price', 8, 2); // Price per cookie at time of order
            $table->decimal('total', 8, 2); // Total for this line (quantity * price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
