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
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('badge', 50)->nullable(); // e.g. 'Popular', 'High ROI'
            $table->decimal('min_amount', 18, 8)->default(0.00000000);
            $table->decimal('max_amount', 18, 8)->default(0.00000000);
            $table->decimal('fixed_amount', 18, 8)->nullable(); // If not range
            $table->decimal('interest_rate', 10, 4); // e.g. 2.5000 %
            $table->string('interest_type', 20)->default('percent'); // 'percent', 'fixed'
            $table->integer('frequency_hours')->default(24); // e.g. 1 for hourly, 24 for daily
            $table->string('frequency_label', 50)->default('Daily'); // 'Hourly', 'Daily', 'Weekly'
            $table->string('duration_type', 20)->default('fixed'); // 'fixed', 'lifetime'
            $table->integer('total_periods')->default(30); // number of ROI cycles
            $table->boolean('capital_back')->default(true); // Return principal at maturity
            $table->string('status', 20)->default('active'); // 'active', 'inactive'
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};
