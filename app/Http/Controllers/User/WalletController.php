<?php

namespace App\Http\Controllers\User;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferFundsRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display the user's financial wallets and internal transfer interface.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        // Ensure all 3 primary wallets are initialized
        $mainWallet = $user->mainWallet();
        $profitWallet = $user->profitWallet();
        $referralWallet = $user->referralWallet();

        // Retrieve recent internal transfers
        $recentTransfers = $user->transactions()
            ->with('wallet')
            ->where('type', Transaction::TYPE_TRANSFER)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('user.wallets.index', [
            'mainWallet' => $mainWallet,
            'profitWallet' => $profitWallet,
            'referralWallet' => $referralWallet,
            'recentTransfers' => $recentTransfers,
        ]);
    }

    /**
     * Handle internal transfer between investor wallets (e.g., profit -> main).
     */
    public function transfer(TransferFundsRequest $request, WalletService $walletService): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $fromWallet = $request->validated('from_wallet');
        $toWallet = $request->validated('to_wallet');
        $amount = (float) $request->validated('amount');

        try {
            $walletService->transfer(
                user: $user,
                fromType: $fromWallet,
                toType: $toWallet,
                amount: $amount,
                description: sprintf('Internal transfer of $%s from %s to %s wallet', number_format($amount, 2), ucfirst($fromWallet), ucfirst($toWallet))
            );

            return redirect()
                ->route('user.wallets')
                ->with('success', sprintf('Successfully transferred $%s from %s Wallet to Main Wallet!', number_format($amount, 2), ucfirst($fromWallet)));
        } catch (InsufficientBalanceException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'An unexpected error occurred while processing your transfer. Please try again.');
        }
    }
}
