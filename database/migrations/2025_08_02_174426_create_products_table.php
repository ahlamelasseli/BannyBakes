<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This creates the products table to store our cookie information.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key (auto-incrementing)
            $table->string('name'); // Cookie name (e.g., "Chocolate Chip")
            $table->text('description'); // Detailed description of the cookie
            $table->decimal('price', 8, 2); // Price with 2 decimal places (e.g., 12.99)
            $table->string('image')->nullable(); // Optional image filename
            $table->boolean('is_active')->default(true); // Whether product is available
            $table->integer('stock_quantity')->default(0); // How many we have in stock
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     * This drops the products table if we need to rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
