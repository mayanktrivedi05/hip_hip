<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@investpro.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Default Test Investor
        $investor = User::firstOrCreate(
            ['email' => 'user@investpro.com'],
            [
                'name' => 'Alex Investor',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Fund demo investor's main wallet with $1,000 for immediate testing
        $mainWallet = $investor->mainWallet();
        if ((float) $mainWallet->balance === 0.0) {
            $mainWallet->update(['balance' => 1000.00000000]);

            Transaction::create([
                'user_id' => $investor->id,
                'wallet_id' => $mainWallet->id,
                'type' => Transaction::TYPE_DEPOSIT,
                'amount' => 1000.00000000,
                'fee' => 0.00000000,
                'post_balance' => 1000.00000000,
                'tx_hash' => Transaction::generateTxHash('DEP'),
                'description' => 'Initial Demo Funding for testing',
                'status' => 'completed',
            ]);
        }

        // 3. Create HyipPro Style Investment Plans
        $plans = [
            [
                'name' => 'Starter Growth Plan',
                'badge' => 'Starter',
                'min_amount' => 50.00000000,
                'max_amount' => 500.00000000,
                'fixed_amount' => null,
                'interest_rate' => 2.0000,
                'interest_type' => 'percent',
                'frequency_hours' => 24,
                'frequency_label' => 'Daily',
                'duration_type' => 'fixed',
                'total_periods' => 30,
                'capital_back' => true,
                'status' => 'active',
                'featured' => false,
                'description' => 'Perfect plan for new investors looking for consistent daily earnings with full principal refund.',
            ],
            [
                'name' => 'Standard Wealth Plan',
                'badge' => 'Most Popular',
                'min_amount' => 500.00000000,
                'max_amount' => 2500.00000000,
                'fixed_amount' => null,
                'interest_rate' => 3.5000,
                'interest_type' => 'percent',
                'frequency_hours' => 24,
                'frequency_label' => 'Daily',
                'duration_type' => 'fixed',
                'total_periods' => 45,
                'capital_back' => true,
                'status' => 'active',
                'featured' => true,
                'description' => 'Our most popular high-yield schema offering balanced returns and daily automated distributions.',
            ],
            [
                'name' => 'VIP Executive Plan',
                'badge' => 'VIP',
                'min_amount' => 2500.00000000,
                'max_amount' => 10000.00000000,
                'fixed_amount' => null,
                'interest_rate' => 5.0000,
                'interest_type' => 'percent',
                'frequency_hours' => 24,
                'frequency_label' => 'Daily',
                'duration_type' => 'fixed',
                'total_periods' => 60,
                'capital_back' => true,
                'status' => 'active',
                'featured' => false,
                'description' => 'High-capital tier for serious investors seeking accelerated wealth generation.',
            ],
            [
                'name' => 'Hourly Speed Yield',
                'badge' => 'Fast Payout',
                'min_amount' => 100.00000000,
                'max_amount' => 1000.00000000,
                'fixed_amount' => null,
                'interest_rate' => 0.2500,
                'interest_type' => 'percent',
                'frequency_hours' => 1,
                'frequency_label' => 'Hourly',
                'duration_type' => 'fixed',
                'total_periods' => 720, // 30 days * 24 hours
                'capital_back' => false,
                'status' => 'active',
                'featured' => false,
                'description' => 'Collect interest payments every single hour straight into your profit wallet.',
            ],
            [
                'name' => 'Crypto Whale Master',
                'badge' => 'Fixed Tier',
                'min_amount' => 5000.00000000,
                'max_amount' => 5000.00000000,
                'fixed_amount' => 5000.00000000,
                'interest_rate' => 12.0000,
                'interest_type' => 'percent',
                'frequency_hours' => 168, // 7 days
                'frequency_label' => 'Weekly',
                'duration_type' => 'fixed',
                'total_periods' => 12,
                'capital_back' => true,
                'status' => 'active',
                'featured' => true,
                'description' => 'Dedicated fixed-tier portfolio with 12% weekly payouts for premier crypto investors.',
            ],
        ];

        foreach ($plans as $planData) {
            InvestmentPlan::updateOrCreate(
                ['name' => $planData['name']],
                $planData
            );
        }
    }
}
