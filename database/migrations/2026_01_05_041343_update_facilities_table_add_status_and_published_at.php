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
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('status')->default('published')->after('description');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->dropColumn(['order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['status', 'published_at']);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }
};
