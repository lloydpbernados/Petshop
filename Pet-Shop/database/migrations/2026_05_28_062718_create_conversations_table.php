<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            
            // Added from the second migration
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name');
            $table->string('email')->nullable(); // Added from the second migration
            $table->string('initials', 10);
            $table->string('status')->default('Away'); // Online, Away, Offline
            $table->string('category')->nullable();    // e.g. "Inquiry: Golden Retriever"
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['sent', 'received'])->default('received');
            $table->text('text');
            $table->timestamps();  // created_at used as message time
        });
    }

    public function down(): void
    {
        // Must drop 'messages' first because it relies on 'conversations'
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};