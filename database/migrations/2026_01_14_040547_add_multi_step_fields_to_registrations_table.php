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
        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('registration_path_id')->nullable()->after('registration_number')->constrained('registration_paths');
            $table->foreignId('first_choice_program_id')->nullable()->after('registration_path_id')->constrained('study_programs');
            $table->foreignId('second_choice_program_id')->nullable()->after('first_choice_program_id')->constrained('study_programs');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('voucher_code', 50)->nullable()->after('address');
            $table->string('referral_code', 50)->nullable()->after('voucher_code');
            $table->string('payment_method', 50)->nullable()->after('referral_code');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('payment_amount');
            $table->decimal('final_amount', 10, 2)->nullable()->after('discount_amount');
            $table->string('payment_proof')->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['registration_path_id']);
            $table->dropForeign(['first_choice_program_id']);
            $table->dropForeign(['second_choice_program_id']);
            $table->dropColumn([
                'registration_path_id',
                'first_choice_program_id',
                'second_choice_program_id',
                'date_of_birth',
                'voucher_code',
                'referral_code',
                'payment_method',
                'discount_amount',
                'final_amount',
                'payment_proof'
            ]);
        });
    }
};
