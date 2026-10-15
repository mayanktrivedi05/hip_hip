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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('method', 50); // 'Bank Transfer', 'UPI', 'USDT TRC20', etc.
            $table->decimal('amount', 18, 8);
            $table->decimal('charge', 18, 8)->default(0.00000000);
            $table->decimal('final_amount', 18, 8);
            $table->string('trx_id', 100)->nullable(); // user transaction reference
            $table->string('payment_proof')->nullable(); // uploaded receipt path
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
        Schema::dropIfExists('deposits');
    }
};
