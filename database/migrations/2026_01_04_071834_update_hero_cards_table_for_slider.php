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
        Schema::table('hero_cards', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->string('button_text')->nullable()->after('background_image');
            $table->string('button_link')->nullable()->after('button_text');
            $table->dropColumn(['icon', 'link']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_cards', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'button_text', 'button_link']);
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
        });
    }
};
