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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Internal primary key
            
            // ✅ Alphanumeric Order ID for customer-facing tracking (e.g., PH-MPATB538-5850)
            $table->string('order_id', 50)->unique()->nullable();
            
            $table->string('email');
            $table->string('customer_name');
            $table->string('item_name');
            $table->decimal('price', 10, 2);
            $table->string('status')->default('Pending');
            $table->text('shipping_address')->nullable();
            $table->text('tracking_notes')->nullable();
            $table->timestamps();
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