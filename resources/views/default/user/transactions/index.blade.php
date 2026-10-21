@extends('layouts.app')

@section('title', 'Financial Ledger')
@section('page_title', 'Audit & Transaction Ledger')

@section('content')
    <div class="space-y-6">
        <!-- Filter and Search Header -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <form method="GET" action="{{ route('user.transactions') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Search Transactions
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-zinc-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ $search }}" 
                            placeholder="Search by TX Hash or Description..." 
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-950 pl-10 pr-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                        />
                    </div>
                </div>

                <!-- Transaction Type Filter -->
                <div>
                    <label for="type" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Operation Type
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-3.5 py-2.5 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                    >
                        <option value="">All Operations</option>
                        <option value="deposit" {{ $currentType === 'deposit' ? 'selected' : '' }}>Deposits</option>
                        <option value="roi_payout" {{ $currentType === 'roi_payout' ? 'selected' : '' }}>ROI Payouts</option>
                        <option value="investment" {{ $currentType === 'investment' ? 'selected' : '' }}>Investments</option>
                        <option value="withdrawal" {{ $currentType === 'withdrawal' ? 'selected' : '' }}>Withdrawals</option>
                        <option value="referral_bonus" {{ $currentType === 'referral_bonus' ? 'selected' : '' }}>Referral Bonuses</option>
                        <option value="transfer" {{ $currentType === 'transfer' ? 'selected' : '' }}>Internal Transfers</option>
                    </select>
                </div>

                <!-- Wallet Type Filter -->
                <div>
                    <label for="wallet" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Target Wallet
                    </label>
                    <div class="flex items-center space-x-2">
                        <select 
                            name="wallet" 
                            id="wallet" 
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-3.5 py-2.5 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                        >
                            <option value="">All Wallets</option>
                            <option value="main" {{ $currentWallet === 'main' ? 'selected' : '' }}>Main Wallet</option>
                            <option value="profit" {{ $currentWallet === 'profit' ? 'selected' : '' }}>Profit Wallet</option>
                            <option value="referral" {{ $currentWallet === 'referral' ? 'selected' : '' }}>Referral Wallet</option>
                        </select>
                        <button 
                            type="submit" 
                            class="rounded-xl bg-lime-500 px-4 py-2.5 text-sm font-bold text-zinc-950 hover:bg-lime-400 transition-colors"
                        >
                            Filter
                        </button>
                        @if($search || $currentType || $currentWallet)
                            <a 
                                href="{{ route('user.transactions') }}" 
                                class="rounded-xl border border-zinc-700 bg-zinc-800 px-3 py-2.5 text-sm font-semibold text-zinc-300 hover:bg-zinc-700 hover:text-white transition-colors"
                                title="Reset Filters"
                            >
                                &times;
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Ledger Table Card -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-white">Audit Entries</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Double-entry verified records with tamper-proof post balances</p>
                </div>
                <span class="rounded-full bg-zinc-800 px-3 py-1 text-xs font-semibold text-zinc-400">
                    {{ $transactions->total() }} Records Total
                </span>
            </div>

            @if($transactions->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-800 py-16 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-zinc-800/80 text-zinc-500 mb-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-white">No transactions found</p>
                    <p class="text-xs text-zinc-400 mt-1 max-w-sm mx-auto">
                        No financial records matched your filter criteria. Try adjusting or clearing your search filters.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="border-b border-zinc-800 text-[11px] uppercase tracking-wider text-zinc-500">
                            <tr>
                                <th class="pb-3">Reference Hash</th>
                                <th class="pb-3">Type</th>
                                <th class="pb-3">Wallet</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Post Balance</th>
                                <th class="pb-3">Description</th>
                                <th class="pb-3 text-right">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-xs">
                            @foreach($transactions as $txn)
                                @php
                                    $isCredit = in_array($txn->type, ['deposit', 'roi_payout', 'referral_bonus']) || str_contains($txn->tx_hash, 'TRF_IN');
                                @endphp
                                <tr class="hover:bg-zinc-800/20 transition-colors">
                                    <td class="py-3.5 font-mono font-semibold text-white">
                                        <span class="inline-flex items-center space-x-1.5">
                                            <span>{{ $txn->tx_hash }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider border
                                            @if($txn->type === 'deposit') bg-lime-500/10 text-lime-400 border-lime-500/20
                                            @elseif($txn->type === 'roi_payout') bg-lime-500/10 text-lime-400 border-lime-500/20
                                            @elseif($txn->type === 'withdrawal') bg-rose-500/10 text-rose-400 border-rose-500/20
                                            @elseif($txn->type === 'referral_bonus') bg-amber-500/10 text-amber-400 border-amber-500/20
                                            @elseif($txn->type === 'investment') bg-sky-500/10 text-sky-400 border-sky-500/20
                                            @else bg-zinc-800 text-zinc-300 border-zinc-700 @endif">
                                            {{ str_replace('_', ' ', $txn->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 text-zinc-400 capitalize">
                                        {{ $txn->wallet?->type ?? 'N/A' }}
                                    </td>
                                    <td class="py-3.5 font-bold {{ $isCredit ? 'text-lime-400' : 'text-rose-400' }}">
                                        {{ $isCredit ? '+' : '-' }}${{ number_format((float) $txn->amount, 2) }}
                                    </td>
                                    <td class="py-3.5 font-medium text-zinc-300">
                                        ${{ number_format((float) $txn->post_balance, 2) }}
                                    </td>
                                    <td class="py-3.5 text-zinc-400 max-w-xs truncate" title="{{ $txn->description }}">
                                        {{ $txn->description }}
                                    </td>
                                    <td class="py-3.5 text-right text-zinc-400">
                                        {{ $txn->created_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 pt-4 border-t border-zinc-800/60">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
