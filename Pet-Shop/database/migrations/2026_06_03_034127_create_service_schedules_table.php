<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->date('date');
            $table->unsignedInteger('slot_limit')->default(10);
            $table->unsignedInteger('booked_count')->default(0);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['service_id', 'date']); // one schedule per service per date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_schedules');
    }
};