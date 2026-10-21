<?php

use App\Exceptions\InsufficientBalanceException;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;

beforeEach(function () {
    $this->walletService = new WalletService;
    $this->user = User::factory()->create();
});

test('it can credit funds to a wallet and write an audit ledger entry', function () {
    $mainWallet = $this->user->mainWallet();
    expect((float) $mainWallet->balance)->toBe(0.0);

    $txn = $this->walletService->credit(
        wallet: $mainWallet,
        amount: 250.50,
        type: Transaction::TYPE_DEPOSIT,
        description: 'Test deposit'
    );

    $mainWallet->refresh();

    expect((float) $mainWallet->balance)->toBe(250.50)
        ->and($txn->amount)->toBe('250.50000000')
        ->and($txn->post_balance)->toBe('250.50000000')
        ->and($txn->type)->toBe(Transaction::TYPE_DEPOSIT)
        ->and($txn->status)->toBe('completed')
        ->and($txn->tx_hash)->toStartWith('CR_');
});

test('credit fails when amount is non-positive', function () {
    $mainWallet = $this->user->mainWallet();

    $this->walletService->credit(
        wallet: $mainWallet,
        amount: 0,
        type: Transaction::TYPE_DEPOSIT
    );
})->throws(InvalidArgumentException::class, 'Credit amount must be greater than zero.');

test('it can debit funds from a wallet with sufficient balance', function () {
    $mainWallet = $this->user->mainWallet();

    // Fund the wallet first
    $this->walletService->credit(
        wallet: $mainWallet,
        amount: 500.00,
        type: Transaction::TYPE_DEPOSIT
    );

    $debitTxn = $this->walletService->debit(
        wallet: $mainWallet,
        amount: 200.00,
        type: Transaction::TYPE_INVESTMENT,
        description: 'Investment plan allocation'
    );

    $mainWallet->refresh();

    expect((float) $mainWallet->balance)->toBe(300.00)
        ->and($debitTxn->amount)->toBe('200.00000000')
        ->and($debitTxn->post_balance)->toBe('300.00000000')
        ->and($debitTxn->type)->toBe(Transaction::TYPE_INVESTMENT)
        ->and($debitTxn->tx_hash)->toStartWith('DB_');
});

test('debit throws InsufficientBalanceException when balance is too low', function () {
    $mainWallet = $this->user->mainWallet();

    $this->walletService->credit(
        wallet: $mainWallet,
        amount: 50.00,
        type: Transaction::TYPE_DEPOSIT
    );

    $this->walletService->debit(
        wallet: $mainWallet,
        amount: 100.00,
        type: Transaction::TYPE_WITHDRAWAL
    );
})->throws(InsufficientBalanceException::class);

test('it can transfer funds between user wallets', function () {
    $profitWallet = $this->user->profitWallet();
    $mainWallet = $this->user->mainWallet();

    // Credit profit wallet with ROI earnings
    $this->walletService->credit(
        wallet: $profitWallet,
        amount: 150.00,
        type: Transaction::TYPE_ROI_PAYOUT
    );

    $result = $this->walletService->transfer(
        user: $this->user,
        fromType: Wallet::TYPE_PROFIT,
        toType: Wallet::TYPE_MAIN,
        amount: 100.00
    );

    $profitWallet->refresh();
    $mainWallet->refresh();

    expect((float) $profitWallet->balance)->toBe(50.00)
        ->and((float) $mainWallet->balance)->toBe(100.00)
        ->and($result['debit']->tx_hash)->toStartWith('TRF_OUT_')
        ->and($result['credit']->tx_hash)->toStartWith('TRF_IN_')
        ->and($result['debit']->amount)->toBe('100.00000000')
        ->and($result['credit']->amount)->toBe('100.00000000');
});

test('transfer fails when source and destination wallet types are the same', function () {
    $this->walletService->transfer(
        user: $this->user,
        fromType: Wallet::TYPE_MAIN,
        toType: Wallet::TYPE_MAIN,
        amount: 50.00
    );
})->throws(InvalidArgumentException::class, 'Source and destination wallets cannot be the same.');

test('transfer throws InsufficientBalanceException when source wallet has insufficient funds', function () {
    $profitWallet = $this->user->profitWallet();
    expect((float) $profitWallet->balance)->toBe(0.0);

    $this->walletService->transfer(
        user: $this->user,
        fromType: Wallet::TYPE_PROFIT,
        toType: Wallet::TYPE_MAIN,
        amount: 25.00
    );
})->throws(InsufficientBalanceException::class);
