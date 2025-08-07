<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
        $table->string('customer_name'); // Customer's full name
        $table->string('customer_email'); // Customer's email
        $table->text('shipping_address'); // Where to deliver the order
        $table->decimal('total_amount', 8, 2); // Total order amount
        $table->string('status')->default('Ordered'); // Order status: Ordered → Packed → Shipped → Delivered
        $table->date('estimated_delivery_date')->nullable(); // When order should arrive
        $table->timestamps(); // created_at and updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
