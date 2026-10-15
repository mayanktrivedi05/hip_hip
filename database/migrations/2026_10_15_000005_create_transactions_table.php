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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            $table->string('type', 30)->index(); // deposit, investment, roi_payout, withdrawal, referral_bonus, transfer
            $table->decimal('amount', 18, 8);
            $table->decimal('fee', 18, 8)->default(0.00000000);
            $table->decimal('post_balance', 18, 8);
            $table->string('tx_hash', 64)->unique()->index();
            $table->string('description')->nullable();
            $table->string('status', 20)->default('completed'); // completed, pending, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
