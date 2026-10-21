@extends('layouts.app')

@section('title', 'Investor Overview')
@section('page_title', 'Portfolio Overview')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Hero Banner -->
        <div class="relative overflow-hidden rounded-2xl border border-lime-500/20 bg-gradient-to-r from-lime-950/30 via-zinc-900/80 to-zinc-900/80 p-6 lg:p-8 backdrop-blur-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <span class="inline-flex items-center space-x-1.5 rounded-full bg-lime-500/10 border border-lime-500/20 px-3 py-1 text-[11px] font-semibold text-lime-400 mb-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400 animate-pulse"></span>
                        <span>HYIP Engine Online</span>
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">
                        Grow Your Capital with Automated Daily ROI
                    </h2>
                    <p class="text-sm text-zinc-400 mt-2 max-w-xl">
                        Deposit funds into your main wallet, select your preferred investment schema, and collect guaranteed profits calculated every hour or day.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="#deposit" class="inline-flex items-center space-x-2 rounded-xl bg-lime-500 px-5 py-3 text-sm font-bold text-zinc-950 shadow-lg shadow-lime-500/20 hover:bg-lime-400 hover:scale-[1.02] transition-all">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Deposit Funds</span>
                    </a>
                    <a href="#plans" class="inline-flex items-center space-x-2 rounded-xl border border-zinc-700 bg-zinc-800/80 px-5 py-3 text-sm font-bold text-zinc-200 hover:bg-zinc-700 hover:text-white transition-all">
                        <span>Invest in Plan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 Key Balance Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Main Wallet -->
            <div class="group relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-lime-500/40 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Main Wallet</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-500/10 text-lime-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-white">${{ $mainBalance }}</h3>
                    <p class="text-xs text-zinc-400 mt-1">Available for new investments</p>
                </div>
            </div>

            <!-- Profit Wallet -->
            <div class="group relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-lime-500/40 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Profit Wallet</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-lime-500/10 text-lime-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-white">${{ $profitBalance }}</h3>
                    <p class="text-xs text-lime-400/90 mt-1">Ready to withdraw or reinvest</p>
                </div>
            </div>

            <!-- Total Invested -->
            <div class="group relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-amber-500/40 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Active Capital</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-white">${{ $totalInvested }}</h3>
                    <p class="text-xs text-amber-400/90 mt-1">{{ $activePlansCount }} Active schemas working</p>
                </div>
            </div>

            <!-- Referral Bonus -->
            <div class="group relative overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl hover:border-zinc-700 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Referral Earnings</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-800 text-zinc-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-white">${{ $referralBalance }}</h3>
                    <p class="text-xs text-zinc-400 mt-1">Multi-level network bonuses</p>
                </div>
            </div>
        </div>

        <!-- Quick Operations Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <a href="#deposit" class="flex items-center space-x-4 rounded-2xl border border-zinc-800/80 bg-zinc-900/40 p-5 hover:border-lime-500/40 hover:bg-zinc-900/70 transition-all group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-500/10 text-lime-400 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white group-hover:text-lime-400 transition-colors">Instant Deposit</h4>
                    <p class="text-xs text-zinc-400 mt-0.5">Top up via UPI, Bank, or Crypto</p>
                </div>
            </a>

            <a href="#plans" class="flex items-center space-x-4 rounded-2xl border border-zinc-800/80 bg-zinc-900/40 p-5 hover:border-lime-500/40 hover:bg-zinc-900/70 transition-all group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-800 text-zinc-300 group-hover:scale-110 group-hover:text-lime-400 transition-all">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white group-hover:text-lime-400 transition-colors">Select Plan</h4>
                    <p class="text-xs text-zinc-400 mt-0.5">Automated return schemas</p>
                </div>
            </a>

            <a href="#withdraw" class="flex items-center space-x-4 rounded-2xl border border-zinc-800/80 bg-zinc-900/40 p-5 hover:border-rose-500/40 hover:bg-zinc-900/70 transition-all group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-500/10 text-rose-400 group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white group-hover:text-rose-400 transition-colors">Payout Cashout</h4>
                    <p class="text-xs text-zinc-400 mt-0.5">Withdraw profits directly</p>
                </div>
            </a>
        </div>

        <!-- Recent Transactions Table Container -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-white">Recent Ledger Transactions</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">All deposits, ROI credits, and withdrawal activities</p>
                </div>
                <a href="{{ route('user.transactions') }}" class="text-xs font-semibold text-lime-400 hover:text-lime-300 transition-colors">
                    View Complete History &rarr;
                </a>
            </div>

            @if($recentTransactions->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-800 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-zinc-800/80 text-zinc-500 mb-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-white">No transactions yet</p>
                    <p class="text-xs text-zinc-400 mt-1 max-w-sm mx-auto">
                        Make your initial deposit to activate investment schemas and start tracking your earnings here.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="border-b border-zinc-800 text-[11px] uppercase tracking-wider text-zinc-500">
                            <tr>
                                <th class="pb-3">Reference</th>
                                <th class="pb-3">Type</th>
                                <th class="pb-3">Wallet</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Post Balance</th>
                                <th class="pb-3 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-xs">
                            @foreach($recentTransactions as $txn)
                                <tr>
                                    <td class="py-3 font-mono font-semibold text-white">{{ $txn->tx_hash }}</td>
                                    <td class="py-3">
                                        <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider border
                                            @if($txn->type === 'deposit') bg-lime-500/10 text-lime-400 border-lime-500/20
                                            @elseif($txn->type === 'roi_payout') bg-zinc-800 text-zinc-300 border-zinc-700
                                            @elseif($txn->type === 'withdrawal') bg-rose-500/10 text-rose-400 border-rose-500/20
                                            @else bg-amber-500/10 text-amber-400 border-amber-500/20 @endif">
                                            {{ str_replace('_', ' ', $txn->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-zinc-400 capitalize">{{ $txn->wallet?->type ?? 'N/A' }}</td>
                                    <td class="py-3 font-bold {{ in_array($txn->type, ['deposit', 'roi_payout', 'referral_bonus']) ? 'text-lime-400' : 'text-rose-400' }}">
                                        {{ in_array($txn->type, ['deposit', 'roi_payout', 'referral_bonus']) ? '+' : '-' }}${{ number_format((float) $txn->amount, 2) }}
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
