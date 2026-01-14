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
        Schema::create('registration_path_study_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_path_id')->constrained('registration_paths')->onDelete('cascade');
            $table->foreignId('study_program_id')->constrained('study_programs')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['registration_path_id', 'study_program_id'], 'unique_path_program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_path_study_program');
    }
};
