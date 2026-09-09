<?php
// database/migrations/2024_01_01_000011_add_completed_at_to_tickets_table.php

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
        Schema::table('tickets', function (Blueprint $table) {
            // Menambahkan kolom completed_at setelah updated_at
            $table->timestamp('completed_at')->nullable()->after('updated_at');
            
            // Menambahkan kolom assigned_to (opsional)
            $table->foreignId('assigned_to')->nullable()->after('completed_at')
                  ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('completed_at');
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
        });
    }
};