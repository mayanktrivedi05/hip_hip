<?php

use App\Models\InvestmentPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserInvestment;
use App\Models\Wallet;

test('a new user automatically receives 3 initialized wallets and a referral code', function () {
    $user = User::factory()->create();

    expect($user->wallets)->toHaveCount(3);

    $mainWallet = $user->wallets->firstWhere('type', Wallet::TYPE_MAIN);
    $profitWallet = $user->wallets->firstWhere('type', Wallet::TYPE_PROFIT);
    $referralWallet = $user->wallets->firstWhere('type', Wallet::TYPE_REFERRAL);

    expect($mainWallet)->not->toBeNull()
        ->and((float) $mainWallet->balance)->toBe(0.0)
        ->and($profitWallet)->not->toBeNull()
        ->and((float) $profitWallet->balance)->toBe(0.0)
        ->and($referralWallet)->not->toBeNull()
        ->and((float) $referralWallet->balance)->toBe(0.0)
        ->and($user->referral_code)->not->toBeNull();
});

test('investment plan correctly calculates periodic return amount', function () {
    $percentPlan = InvestmentPlan::create([
        'name' => 'Test Percent Plan',
        'min_amount' => 100,
        'max_amount' => 1000,
        'interest_rate' => 2.5000,
        'interest_type' => 'percent',
        'frequency_hours' => 24,
        'frequency_label' => 'Daily',
        'total_periods' => 30,
        'capital_back' => true,
    ]);

    // 2.5% of 200 = 5.00
    $return = $percentPlan->calculatePeriodicReturn(200);
    expect((float) $return)->toBe(5.0);

    $fixedPlan = InvestmentPlan::create([
        'name' => 'Test Fixed Plan',
        'fixed_amount' => 500,
        'interest_rate' => 15.0000,
        'interest_type' => 'fixed',
        'frequency_hours' => 24,
        'frequency_label' => 'Daily',
        'total_periods' => 10,
        'capital_back' => true,
    ]);

    // Fixed return of 15.00
    $fixedReturn = $fixedPlan->calculatePeriodicReturn(500);
    expect((float) $fixedReturn)->toBe(15.0);
});

test('user dashboard renders dynamic wallet balances and transactions', function () {
    $user = User::factory()->create();
    $mainWallet = $user->mainWallet();
    $mainWallet->update(['balance' => 450.50]);

    Transaction::create([
        'user_id' => $user->id,
        'wallet_id' => $mainWallet->id,
        'type' => Transaction::TYPE_DEPOSIT,
        'amount' => 450.50,
        'fee' => 0,
        'post_balance' => 450.50,
        'tx_hash' => 'TXN_TEST_12345',
        'status' => 'completed',
    ]);

    $response = $this->actingAs($user)->get(route('user.dashboard'));

    $response->assertOk()
        ->assertSee('$450.50')
        ->assertSee('TXN_TEST_12345');
});

test('admin dashboard renders live platform investor statistics', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('System Analytics & Overview');
});

test('user investment due payout scope selects only matured investments', function () {
    $user = User::factory()->create();
    $plan = InvestmentPlan::first() ?? InvestmentPlan::create([
        'name' => 'Scope Plan',
        'min_amount' => 100,
        'max_amount' => 1000,
        'interest_rate' => 3,
        'interest_type' => 'percent',
        'total_periods' => 10,
    ]);

    // Due investment (next_payout_at in the past)
    $dueInvestment = UserInvestment::create([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'invested_amount' => 100,
        'return_per_period' => 3,
        'total_periods' => 10,
        'periods_received' => 0,
        'total_returned' => 0,
        'next_payout_at' => now()->subMinutes(10),
        'status' => UserInvestment::STATUS_ACTIVE,
    ]);

    // Future investment (next_payout_at in the future)
    $futureInvestment = UserInvestment::create([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'invested_amount' => 100,
        'return_per_period' => 3,
        'total_periods' => 10,
        'periods_received' => 0,
        'total_returned' => 0,
        'next_payout_at' => now()->addHours(5),
        'status' => UserInvestment::STATUS_ACTIVE,
    ]);

    $dueItems = UserInvestment::dueForPayout()->get();

    expect($dueItems->pluck('id'))->toContain($dueInvestment->id)
        ->and($dueItems->pluck('id'))->not->toContain($futureInvestment->id);
});
