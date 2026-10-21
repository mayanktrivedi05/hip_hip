@extends('layouts.app')

@section('title', 'My Wallets & Transfers')
@section('page_title', 'Wallet Balances & Transfer')

@section('content')
    <div class="space-y-8">
        <!-- Header Banner -->
        <div class="relative overflow-hidden rounded-2xl border border-lime-500/20 bg-gradient-to-r from-lime-950/30 via-zinc-900/80 to-zinc-900/80 p-6 lg:p-8 backdrop-blur-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <span class="inline-flex items-center space-x-1.5 rounded-full bg-lime-500/10 border border-lime-500/20 px-3 py-1 text-[11px] font-semibold text-lime-400 mb-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400 animate-pulse"></span>
                        <span>Zero-Fee Internal Transfers</span>
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">
                        Multi-Wallet Financial Management
                    </h2>
                    <p class="text-sm text-zinc-400 mt-2 max-w-xl">
                        Seamlessly move profits or referral bonuses into your Main Wallet for instant schema reinvestment or cashout.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.transactions') }}" class="inline-flex items-center space-x-2 rounded-xl border border-zinc-700 bg-zinc-800/80 px-5 py-3 text-sm font-bold text-zinc-200 hover:bg-zinc-700 hover:text-white transition-all">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Full Ledger</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 3 Wallet Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Wallet Card -->
            <div class="relative overflow-hidden rounded-2xl border border-lime-500/30 bg-zinc-900/70 p-6 backdrop-blur-xl shadow-lg shadow-lime-500/5">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-lime-400">Primary Wallet</span>
                        <h3 class="text-lg font-bold text-white mt-0.5">Main Wallet</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-500/10 text-lime-400 border border-lime-500/20">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        ${{ $mainWallet->formattedBalance() }}
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">Active capital available for plan subscriptions & withdrawals.</p>
                </div>
            </div>

            <!-- Profit Wallet Card -->
            <div class="relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-lime-500/30 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Earnings Wallet</span>
                        <h3 class="text-lg font-bold text-white mt-0.5">Profit Wallet</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-800 text-lime-400 border border-zinc-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        ${{ $profitWallet->formattedBalance() }}
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">Automated hourly & daily interest payouts collected here.</p>
                </div>
            </div>

            <!-- Referral Wallet Card -->
            <div class="relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-zinc-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Network Wallet</span>
                        <h3 class="text-lg font-bold text-white mt-0.5">Referral Wallet</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-800 text-zinc-300 border border-zinc-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        ${{ $referralWallet->formattedBalance() }}
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">Multi-tier commission rewards from invited investors.</p>
                </div>
            </div>
        </div>

        <!-- Transfer Form & Explanation Split Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Transfer Form -->
            <div class="lg:col-span-2 rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 lg:p-8 backdrop-blur-xl">
                <div class="flex items-center space-x-3 mb-6 pb-6 border-b border-zinc-800/60">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-500/10 text-lime-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Instant Internal Transfer</h3>
                        <p class="text-xs text-zinc-400">Transfer earnings to your Main Wallet with zero commission</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('user.wallets.transfer') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Source Wallet -->
                        <div>
                            <label for="from_wallet" class="block text-xs font-semibold uppercase tracking-wider text-zinc-300 mb-2">
                                Transfer From
                            </label>
                            <select 
                                id="from_wallet" 
                                name="from_wallet" 
                                class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                                required
                            >
                                <option value="profit" {{ old('from_wallet') === 'profit' ? 'selected' : '' }}>
                                    Profit Wallet (${{ $profitWallet->formattedBalance() }})
                                </option>
                                <option value="referral" {{ old('from_wallet') === 'referral' ? 'selected' : '' }}>
                                    Referral Wallet (${{ $referralWallet->formattedBalance() }})
                                </option>
                            </select>
                            @error('from_wallet')
                                <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Destination Wallet -->
                        <div>
                            <label for="to_wallet" class="block text-xs font-semibold uppercase tracking-wider text-zinc-300 mb-2">
                                Transfer To
                            </label>
                            <select 
                                id="to_wallet" 
                                name="to_wallet" 
                                class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors cursor-not-allowed"
                                readonly
                            >
                                <option value="main" selected>
                                    Main Wallet (${{ $mainWallet->formattedBalance() }})
                                </option>
                            </select>
                            @error('to_wallet')
                                <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Amount Input -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="amount" class="text-xs font-semibold uppercase tracking-wider text-zinc-300">
                                Transfer Amount ($ USD)
                            </label>
                            <span class="text-xs text-zinc-400">
                                Minimum: $1.00
                            </span>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 font-bold">$</span>
                            <input 
                                type="number" 
                                step="any" 
                                id="amount" 
                                name="amount" 
                                value="{{ old('amount') }}" 
                                placeholder="0.00" 
                                class="w-full rounded-xl border border-zinc-800 bg-zinc-950 pl-8 pr-4 py-3 text-sm text-white placeholder-zinc-600 focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                                required
                            />
                        </div>
                        @error('amount')
                            <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 rounded-xl bg-lime-500 px-6 py-3 text-sm font-bold text-zinc-950 hover:bg-lime-400 transition-all shadow-md shadow-lime-500/20"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Confirm Internal Transfer</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transfer Rules & Guidelines -->
            <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 lg:p-8 backdrop-blur-xl space-y-5">
                <h4 class="text-base font-bold text-white flex items-center space-x-2">
                    <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Transfer Guidelines</span>
                </h4>

                <ul class="space-y-4 text-xs text-zinc-400 leading-relaxed">
                    <li class="flex items-start space-x-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400 mt-1.5 shrink-0"></span>
                        <span><strong>Zero Transaction Fee:</strong> All internal transfers between wallets are processed at 0.00% network fee.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400 mt-1.5 shrink-0"></span>
                        <span><strong>Instant Availability:</strong> Funds reflect in your Main Wallet immediately with no waiting period.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400 mt-1.5 shrink-0"></span>
                        <span><strong>Compound Reinvesting:</strong> Move your profit balances to Main Wallet to activate new high-yield investment schemas anytime.</span>
                    </li>
                </ul>

                <div class="rounded-xl border border-zinc-800 bg-zinc-950/70 p-4">
                    <div class="flex items-center space-x-2 text-zinc-300 font-semibold text-xs mb-1">
                        <svg class="h-4 w-4 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Ledger Protected</span>
                    </div>
                    <p class="text-[11px] text-zinc-400">
                        Every transfer generates an immutable double-entry cryptographic record in the system ledger.
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Internal Transfers History -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-white">Recent Internal Transfers</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Audit records of your profit and commission relocations</p>
                </div>
                <a href="{{ route('user.transactions', ['type' => 'transfer']) }}" class="text-xs font-semibold text-lime-400 hover:text-lime-300 transition-colors">
                    View All Transfers &rarr;
                </a>
            </div>

            @if($recentTransfers->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-800 py-10 text-center">
                    <p class="text-sm font-semibold text-white">No internal transfers yet</p>
                    <p class="text-xs text-zinc-400 mt-1">When you transfer earnings between wallets, they will be logged here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="border-b border-zinc-800 text-[11px] uppercase tracking-wider text-zinc-500">
                            <tr>
                                <th class="pb-3">Reference</th>
                                <th class="pb-3">Wallet</th>
                                <th class="pb-3">Description</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Post Balance</th>
                                <th class="pb-3 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-xs">
                            @foreach($recentTransfers as $txn)
                                <tr>
                                    <td class="py-3 font-mono font-semibold text-white">{{ $txn->tx_hash }}</td>
                                    <td class="py-3 text-zinc-400 capitalize">{{ $txn->wallet?->type ?? 'N/A' }}</td>
                                    <td class="py-3 text-zinc-300">{{ $txn->description }}</td>
                                    <td class="py-3 font-bold {{ str_contains($txn->tx_hash, 'TRF_IN') ? 'text-lime-400' : 'text-zinc-300' }}">
                                        {{ str_contains($txn->tx_hash, 'TRF_IN') ? '+' : '-' }}${{ number_format((float) $txn->amount, 2) }}
                                    </td>
                                    <td class="py-3 text-zinc-400">${{ number_format((float) $txn->post_balance, 2) }}</td>
                                    <td class="py-3 text-right text-zinc-400">{{ $txn->created_at->format('M d, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
