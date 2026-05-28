<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique()->nullable();
            $table->string('customer_name');
            $table->string('email');
            $table->text('shipping_address')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('cash');
            $table->string('gcash_reference')->nullable();
            $table->text('tracking_notes')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};