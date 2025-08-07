<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This creates the order_items table to store individual items in each order.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Links to orders table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Links to products table
            $table->string('product_name'); // Store product name at time of order
            $table->decimal('product_price', 8, 2); // Store price at time of order
            $table->integer('quantity'); // How many of this product
            $table->decimal('subtotal', 8, 2); // Total for this line item (quantity * price)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     * This drops the order_items table if we need to rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
