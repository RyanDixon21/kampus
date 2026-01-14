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
        Schema::table('study_programs', function (Blueprint $table) {
            $table->string('program_type', 10)->after('degree_level')->default('IPS'); // IPA, IPS
            
            // Add index for filtering by program type
            $table->index(['program_type', 'is_active'], 'idx_program_type_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropIndex('idx_program_type_active');
            $table->dropColumn('program_type');
        });
    }
};
