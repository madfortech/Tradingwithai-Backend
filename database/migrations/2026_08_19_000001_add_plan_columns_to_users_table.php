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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->unsignedInteger('ai_credits')->default(0);
            $table->unsignedInteger('daily_ai_credits_used')->default(0);
            $table->timestamp('credits_reset_at')->nullable();
            $table->timestamp('daily_reset_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn([
                'plan_id',
                'ai_credits',
                'daily_ai_credits_used',
                'credits_reset_at',
                'daily_reset_at',
            ]);
        });
    }
};
