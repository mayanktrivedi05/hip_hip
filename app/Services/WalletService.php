<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class WalletService
{
    /**
     * Credit funds to a wallet with pessimistic locking and immutable transaction logging.
     *
     * @param  array<string, mixed>  $meta
     */
    public function credit(
        Wallet $wallet,
        float|string $amount,
        string $type,
        string $description = '',
        float|string $fee = 0.0,
        array $meta = []
    ): Transaction {
        $amountStr = number_format((float) $amount, 8, '.', '');
        $feeStr = number_format((float) $fee, 8, '.', '');

        if (bccomp($amountStr, '0.00000000', 8) <= 0) {
            throw new InvalidArgumentException('Credit amount must be greater than zero.');
        }

        return DB::transaction(function () use ($wallet, $amountStr, $feeStr, $type, $description) {
            /** @var Wallet $lockedWallet */
            $lockedWallet = Wallet::where('id', $wallet->id)->lockForUpdate()->firstOrFail();

            $newBalance = bcadd((string) $lockedWallet->balance, $amountStr, 8);

            $lockedWallet->update([
                'balance' => $newBalance,
            ]);

            return Transaction::create([
                'user_id' => $lockedWallet->user_id,
                'wallet_id' => $lockedWallet->id,
                'type' => $type,
                'amount' => $amountStr,
                'fee' => $feeStr,
                'post_balance' => $newBalance,
                'tx_hash' => Transaction::generateTxHash('CR'),
                'description' => $description ?: 'Wallet credit of $'.number_format((float) $amountStr, 2),
                'status' => 'completed',
            ]);
        });
    }

    /**
     * Debit funds from a wallet with pessimistic locking, sufficiency verification, and ledger logging.
     *
     * @param  array<string, mixed>  $meta
     *
     * @throws InsufficientBalanceException
     */
    public function debit(
        Wallet $wallet,
        float|string $amount,
        string $type,
        string $description = '',
        float|string $fee = 0.0,
        array $meta = []
    ): Transaction {
        $amountStr = number_format((float) $amount, 8, '.', '');
        $feeStr = number_format((float) $fee, 8, '.', '');

        if (bccomp($amountStr, '0.00000000', 8) <= 0) {
            throw new InvalidArgumentException('Debit amount must be greater than zero.');
        }

        return DB::transaction(function () use ($wallet, $amountStr, $feeStr, $type, $description) {
            /** @var Wallet $lockedWallet */
            $lockedWallet = Wallet::where('id', $wallet->id)->lockForUpdate()->firstOrFail();

            $currentBalance = (string) $lockedWallet->balance;

            if (bccomp($currentBalance, $amountStr, 8) < 0) {
                throw new InsufficientBalanceException(sprintf(
                    'Insufficient balance in %s wallet. Current: $%s, Required: $%s',
                    ucfirst($lockedWallet->type),
                    number_format((float) $currentBalance, 2),
                    number_format((float) $amountStr, 2)
                ));
            }

            $newBalance = bcsub($currentBalance, $amountStr, 8);

            $lockedWallet->update([
                'balance' => $newBalance,
            ]);

            return Transaction::create([
                'user_id' => $lockedWallet->user_id,
                'wallet_id' => $lockedWallet->id,
                'type' => $type,
                'amount' => $amountStr,
                'fee' => $feeStr,
                'post_balance' => $newBalance,
                'tx_hash' => Transaction::generateTxHash('DB'),
                'description' => $description ?: 'Wallet debit of $'.number_format((float) $amountStr, 2),
                'status' => 'completed',
            ]);
        });
    }

    /**
     * Internal transfer between user's own wallets (e.g., profit -> main or referral -> main).
     *
     * @return array{debit: Transaction, credit: Transaction}
     *
     * @throws InsufficientBalanceException
     */
    public function transfer(
        User $user,
        string $fromType,
        string $toType,
        float|string $amount,
        string $description = ''
    ): array {
        if ($fromType === $toType) {
            throw new InvalidArgumentException('Source and destination wallets cannot be the same.');
        }

        $amountStr = number_format((float) $amount, 8, '.', '');
        if (bccomp($amountStr, '0.00000000', 8) <= 0) {
            throw new InvalidArgumentException('Transfer amount must be greater than zero.');
        }

        $fromWallet = $user->getWallet($fromType);
        $toWallet = $user->getWallet($toType);

        return DB::transaction(function () use ($user, $fromWallet, $toWallet, $amountStr, $description) {
            $walletIds = [$fromWallet->id, $toWallet->id];
            sort($walletIds);

            Wallet::whereIn('id', $walletIds)->lockForUpdate()->get();

            $lockedFrom = Wallet::findOrFail($fromWallet->id);
            $lockedTo = Wallet::findOrFail($toWallet->id);

            $currentFromBalance = (string) $lockedFrom->balance;
            if (bccomp($currentFromBalance, $amountStr, 8) < 0) {
                throw new InsufficientBalanceException(sprintf(
                    'Insufficient balance in %s wallet. Current: $%s, Requested: $%s',
                    ucfirst($lockedFrom->type),
                    number_format((float) $currentFromBalance, 2),
                    number_format((float) $amountStr, 2)
                ));
            }

            $newFromBalance = bcsub($currentFromBalance, $amountStr, 8);
            $lockedFrom->update(['balance' => $newFromBalance]);

            $debitTxn = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $lockedFrom->id,
                'type' => Transaction::TYPE_TRANSFER,
                'amount' => $amountStr,
                'fee' => 0.00000000,
                'post_balance' => $newFromBalance,
                'tx_hash' => Transaction::generateTxHash('TRF_OUT'),
                'description' => $description ?: sprintf('Internal transfer to %s wallet', ucfirst($lockedTo->type)),
                'status' => 'completed',
            ]);

            $currentToBalance = (string) $lockedTo->balance;
            $newToBalance = bcadd($currentToBalance, $amountStr, 8);
            $lockedTo->update(['balance' => $newToBalance]);

            $creditTxn = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $lockedTo->id,
                'type' => Transaction::TYPE_TRANSFER,
                'amount' => $amountStr,
                'fee' => 0.00000000,
                'post_balance' => $newToBalance,
                'tx_hash' => Transaction::generateTxHash('TRF_IN'),
                'description' => $description ?: sprintf('Internal transfer from %s wallet', ucfirst($lockedFrom->type)),
                'status' => 'completed',
            ]);

            return [
                'debit' => $debitTxn,
                'credit' => $creditTxn,
            ];
        });
    }
}
