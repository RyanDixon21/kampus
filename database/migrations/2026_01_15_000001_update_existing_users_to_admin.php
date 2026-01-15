<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add role column if it doesn't exist
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('email');
            });
        }
        
        // Update all existing users to admin role
        // (You can modify this to only update specific users if needed)
        DB::table('users')->update(['role' => 'admin']);
    }

    public function down(): void
    {
        // Optionally revert users back to 'user' role
        DB::table('users')->update(['role' => 'user']);
    }
};
