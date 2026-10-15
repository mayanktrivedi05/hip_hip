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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('method', 50); // 'Bank Account', 'UPI ID', 'Crypto Wallet'
            $table->decimal('amount', 18, 8);
            $table->decimal('charge', 18, 8)->default(0.00000000);
            $table->decimal('final_amount', 18, 8);
            $table->text('account_details'); // Details of payout destination
            $table->string('status', 20)->default('pending')->index(); // 'pending', 'approved', 'rejected'
            $table->text('admin_feedback')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
