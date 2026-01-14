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
        Schema::table('registration_paths', function (Blueprint $table) {
            $table->string('degree_level', 10)->after('system_type')->default('S1'); // S1, D3, S2
            $table->string('wave', 50)->nullable()->after('degree_level'); // Gelombang 1, Gelombang 2
            $table->string('period', 50)->nullable()->after('wave'); // 2026 Ganjil
            
            // Add index for filtering
            $table->index(['degree_level', 'system_type', 'is_active'], 'idx_path_filters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_paths', function (Blueprint $table) {
            $table->dropIndex('idx_path_filters');
            $table->dropColumn(['degree_level', 'wave', 'period']);
        });
    }
};
