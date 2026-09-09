<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('response');
            $table->boolean('is_admin_response')->default(false);
            $table->timestamps();

            // Index untuk optimasi query
            $table->index('ticket_id');
            $table->index('user_id');
            $table->index('created_at');
            $table->index('is_admin_response');

            // Composite index
            $table->index(['ticket_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_responses');
    }
};