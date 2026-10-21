@extends('layouts.admin')

@section('title', 'Master System Ledger')
@section('page_title', 'Master Financial Ledger')

@section('content')
    <div class="space-y-8">
        <!-- KPI Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total System Volume</span>
                <h3 class="text-3xl font-extrabold text-white mt-2">${{ $stats['total_volume'] }}</h3>
                <p class="text-xs text-lime-400 mt-1">Total Verified Turnover</p>
            </div>

            <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Audit Logs</span>
                <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['total_txns'] }}</h3>
                <p class="text-xs text-zinc-400 mt-1">Completed Ledger Entries</p>
            </div>

            <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Deposit Entries</span>
                <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['deposits_count'] }}</h3>
                <p class="text-xs text-lime-400 mt-1">Capital Inflow Operations</p>
            </div>

            <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">ROI Distributions</span>
                <h3 class="text-3xl font-extrabold text-white mt-2">{{ $stats['roi_count'] }}</h3>
                <p class="text-xs text-amber-400 mt-1">Automated Yield Credits</p>
            </div>
        </div>

        <!-- Filter and Search Header -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <form method="GET" action="{{ route('admin.transactions') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Search Member / TX Hash
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
                            placeholder="Search name, email, or TX hash..." 
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-950 pl-10 pr-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                        />
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Operation Type
                    </label>
                    <select 
                        name="type" 
                        id="type" 
                        class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-3.5 py-2.5 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                    >
                        <option value="">All Types</option>
                        <option value="deposit" {{ $currentType === 'deposit' ? 'selected' : '' }}>Deposit</option>
                        <option value="roi_payout" {{ $currentType === 'roi_payout' ? 'selected' : '' }}>ROI Payout</option>
                        <option value="investment" {{ $currentType === 'investment' ? 'selected' : '' }}>Investment</option>
                        <option value="withdrawal" {{ $currentType === 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                        <option value="referral_bonus" {{ $currentType === 'referral_bonus' ? 'selected' : '' }}>Referral Bonus</option>
                        <option value="transfer" {{ $currentType === 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>

                <!-- Wallet Filter -->
                <div>
                    <label for="wallet" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Wallet Type
                    </label>
                    <select 
                        name="wallet" 
                        id="wallet" 
                        class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-3.5 py-2.5 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                    >
                        <option value="">All Wallets</option>
                        <option value="main" {{ $currentWallet === 'main' ? 'selected' : '' }}>Main</option>
                        <option value="profit" {{ $currentWallet === 'profit' ? 'selected' : '' }}>Profit</option>
                        <option value="referral" {{ $currentWallet === 'referral' ? 'selected' : '' }}>Referral</option>
                    </select>
                </div>

                <!-- Status & Submit -->
                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-1.5">
                        Status
                    </label>
                    <div class="flex items-center space-x-2">
                        <select 
                            name="status" 
                            id="status" 
                            class="w-full rounded-xl border border-zinc-800 bg-zinc-950 px-3.5 py-2.5 text-sm text-white focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500 transition-colors"
                        >
                            <option value="">All Statuses</option>
                            <option value="completed" {{ $currentStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ $currentStatus === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        <button 
                            type="submit" 
                            class="rounded-xl bg-lime-500 px-4 py-2.5 text-sm font-bold text-zinc-950 hover:bg-lime-400 transition-colors shrink-0"
                        >
                            Filter
                        </button>
                        @if($search || $currentType || $currentWallet || $currentStatus)
                            <a 
                                href="{{ route('admin.transactions') }}" 
                                class="rounded-xl border border-zinc-700 bg-zinc-800 px-3 py-2.5 text-sm font-semibold text-zinc-300 hover:bg-zinc-700 hover:text-white transition-colors shrink-0"
                                title="Reset"
                            >
                                &times;
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Master Table Card -->
        <div class="rounded-2xl border border-zinc-800/80 bg-zinc-900/60 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-white">System Ledger Transactions</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Global immutable audit trail across all investor accounts</p>
                </div>
                <span class="rounded-full bg-zinc-800 px-3 py-1 text-xs font-semibold text-zinc-400">
                    {{ $transactions->total() }} Total Transactions
                </span>
            </div>

            @if($transactions->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-800 py-16 text-center">
                    <p class="text-sm font-semibold text-white">No ledger entries found</p>
                    <p class="text-xs text-zinc-400 mt-1">Try resetting the filters above to view all records.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="border-b border-zinc-800 text-[11px] uppercase tracking-wider text-zinc-500">
                            <tr>
                                <th class="pb-3">Member</th>
                                <th class="pb-3">Reference Hash</th>
                                <th class="pb-3">Type</th>
                                <th class="pb-3">Wallet</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Post Balance</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-xs">
                            @foreach($transactions as $txn)
                                @php
                                    $isCredit = in_array($txn->type, ['deposit', 'roi_payout', 'referral_bonus']) || str_contains($txn->tx_hash, 'TRF_IN');
                                @endphp
                                <tr class="hover:bg-zinc-800/20 transition-colors">
                                    <td class="py-3.5">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-zinc-800 text-lime-400 font-bold text-xs border border-zinc-700">
                                                {{ strtoupper(substr($txn->user?->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white leading-tight">{{ $txn->user?->name ?? 'Deleted User' }}</p>
                                                <p class="text-[10px] text-zinc-400">{{ $txn->user?->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 font-mono font-semibold text-white">
                                        {{ $txn->tx_hash }}
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
                                    <td class="py-3.5">
                                        <span class="inline-flex items-center space-x-1 text-[10px] font-bold uppercase tracking-wider
                                            {{ $txn->status === 'completed' ? 'text-lime-400' : ($txn->status === 'pending' ? 'text-amber-400' : 'text-rose-400') }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $txn->status === 'completed' ? 'bg-lime-400' : ($txn->status === 'pending' ? 'bg-amber-400' : 'bg-rose-400') }}"></span>
                                            <span>{{ $txn->status }}</span>
                                        </span>
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
