<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stores recent activity events shown on the admin dashboard.
        // Auto-populated by Observers on Order, Message, Service, etc.
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type');    // Order, Inquiry, Service, System
            $table->string('user');    // Customer or system actor name
            $table->string('detail');  // Human-readable description
            $table->string('status');  // Pending, New, Processing, Alert, Confirmed, etc.
            $table->string('icon')->default('📝');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};