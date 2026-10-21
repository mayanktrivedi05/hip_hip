<?php

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;

test('guest cannot access user wallets or transactions', function () {
    $this->get(route('user.wallets'))->assertRedirect(route('login'));
    $this->get(route('user.transactions'))->assertRedirect(route('login'));
});

test('investor can view the wallets page with balance cards', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('user.wallets'));

    $response->assertStatus(200);
    $response->assertSee('Multi-Wallet Financial Management');
    $response->assertSee('Main Wallet');
    $response->assertSee('Profit Wallet');
    $response->assertSee('Referral Wallet');
    $response->assertSee('Instant Internal Transfer');
});

test('investor can view transactions ledger with filter options', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('user.transactions'));

    $response->assertStatus(200);
    $response->assertSee('Financial Ledger');
    $response->assertSee('Audit Entries');
    $response->assertSee('Search Transactions');
});

test('investor can transfer funds from profit wallet to main wallet via web form', function () {
    $user = User::factory()->create();
    $walletService = new WalletService;

    // Fund the profit wallet with 100
    $walletService->credit(
        wallet: $user->profitWallet(),
        amount: 100.00,
        type: Transaction::TYPE_ROI_PAYOUT
    );

    $response = $this->actingAs($user)->post(route('user.wallets.transfer'), [
        'from_wallet' => Wallet::TYPE_PROFIT,
        'to_wallet' => Wallet::TYPE_MAIN,
        'amount' => 45.00,
    ]);

    $response->assertRedirect(route('user.wallets'));
    $response->assertSessionHas('success');

    $user->profitWallet()->refresh();
    $user->mainWallet()->refresh();

    expect((float) $user->profitWallet()->balance)->toBe(55.00)
        ->and((float) $user->mainWallet()->balance)->toBe(45.00);
});

test('investor receives validation error when attempting to transfer more than available balance', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('user.wallets.transfer'), [
        'from_wallet' => Wallet::TYPE_PROFIT,
        'to_wallet' => Wallet::TYPE_MAIN,
        'amount' => 500.00,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});

test('admin can access system-wide transactions ledger', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.transactions'));

    $response->assertStatus(200);
    $response->assertSee('Master Financial Ledger');
    $response->assertSee('Total System Volume');
});

test('standard investor cannot access admin transactions ledger', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.transactions'));

    $response->assertStatus(403);
});
