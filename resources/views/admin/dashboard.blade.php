@extends('layouts.admin')

@section('title', 'Admin Master Overview')
@section('page_title', 'System Analytics & Overview')

@section('content')
    <div class="space-y-8">
        <!-- Admin KPI Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Investors -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Investors</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-white">{{ $totalInvestors }}</h3>
                    <p class="text-xs text-indigo-400 mt-1">Registered Platform Members</p>
                </div>
            </div>

            <!-- Total Platform Deposits -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Deposits</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-white">${{ $totalDeposits }}</h3>
                    <p class="text-xs text-emerald-400 mt-1">Total Funds Inflow</p>
                </div>
            </div>

            <!-- Total Withdrawals -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Payouts</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-500/10 text-rose-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-white">${{ $totalWithdrawals }}</h3>
                    <p class="text-xs text-rose-400 mt-1">Total Funds Outflow</p>
                </div>
            </div>

            <!-- Total Invested in Schemas -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active Capital</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-white">${{ $totalInvested }}</h3>
                    <p class="text-xs text-amber-400 mt-1">Capital Locked in Schemas</p>
                </div>
            </div>
        </div>

        <!-- Action Pending Quick Banners -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Deposit Requests Alert -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl flex items-center justify-between">
                <div>
                    <span class="inline-flex items-center space-x-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-[11px] font-semibold text-emerald-400 mb-2">
                        <span>Deposits Gateway</span>
                    </span>
                    <h4 class="text-lg font-bold text-white">Manual Deposits Verification</h4>
                    <p class="text-xs text-slate-400 mt-1">{{ $pendingDepositsCount }} pending proof submissions awaiting review</p>
                </div>
                <a href="#admin-deposits" class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-xs font-semibold text-slate-200 hover:bg-slate-700 transition-colors">
                    Review Slips &rarr;
                </a>
            </div>

            <!-- Withdrawal Requests Alert -->
            <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl flex items-center justify-between">
                <div>
                    <span class="inline-flex items-center space-x-1.5 rounded-full bg-rose-500/10 px-2.5 py-1 text-[11px] font-semibold text-rose-400 mb-2">
                        <span>Withdrawals Gateway</span>
                    </span>
                    <h4 class="text-lg font-bold text-white">Investor Payout Requests</h4>
                    <p class="text-xs text-slate-400 mt-1">{{ $pendingWithdrawalsCount }} pending withdrawal authorizations</p>
                </div>
                <a href="#admin-withdrawals" class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-xs font-semibold text-slate-200 hover:bg-slate-700 transition-colors">
                    Review Payouts &rarr;
                </a>
            </div>
        </div>

        <!-- Recent Registered Users -->
        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-6 backdrop-blur-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-white">Recent Registered Members</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Latest investors who created an account</p>
                </div>
                <a href="#admin-users" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors">
                    View All Investors &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="border-b border-slate-800 text-[11px] uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Joined Date</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-xs">
                        @forelse($recentUsers as $user)
                            <tr>
                                <td class="py-3 font-semibold text-white">{{ $user->name }}</td>
                                <td class="py-3 text-slate-400">{{ $user->email }}</td>
                                <td class="py-3">
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold {{ $user->role === 'admin' ? 'bg-indigo-500/20 text-indigo-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 text-slate-400">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="py-3 text-right">
                                    <span class="text-slate-500 hover:text-white cursor-pointer font-medium">Manage</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
