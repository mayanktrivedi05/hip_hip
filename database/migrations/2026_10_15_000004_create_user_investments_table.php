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
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('investment_plans')->cascadeOnDelete();
            $table->decimal('invested_amount', 18, 8);
            $table->decimal('return_per_period', 18, 8);
            $table->integer('total_periods');
            $table->integer('periods_received')->default(0);
            $table->decimal('total_returned', 18, 8)->default(0.00000000);
            $table->timestamp('next_payout_at')->nullable()->index();
            $table->string('status', 20)->default('active')->index(); // 'active', 'completed', 'cancelled'
            $table->timestamp('capital_returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
