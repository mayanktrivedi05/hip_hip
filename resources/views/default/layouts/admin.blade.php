<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Control') - HIP HIP Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false }" class="min-h-screen bg-zinc-950 font-sans text-zinc-200 antialiased selection:bg-lime-500 selection:text-zinc-950">
    <!-- Ambient Background Glow for Admin (Zinc & Lime Tones) -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-32 right-1/4 h-96 w-96 rounded-full bg-zinc-800/40 blur-[130px]"></div>
        <div class="absolute top-1/2 left-10 h-80 w-80 rounded-full bg-lime-500/5 blur-[140px]"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-black/80 backdrop-blur-sm lg:hidden"
            style="display: none;"
        ></div>

        <!-- Admin Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-zinc-800/80 bg-zinc-950/95 backdrop-blur-xl transition-transform duration-300 ease-in-out lg:static"
        >
            <!-- Admin Header -->
            <div class="flex h-20 items-center justify-between px-6 border-b border-zinc-800/60">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-lime-400 via-lime-500 to-lime-600 p-[2px] shadow-md shadow-lime-500/20 group-hover:scale-105 transition-transform">
                        <div class="h-full w-full bg-zinc-950 rounded-[10px] flex items-center justify-center">
                            <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-white block">SUPER <span class="text-lime-400">ADMIN</span></span>
                        <span class="text-[9px] uppercase tracking-widest text-zinc-400 font-semibold">Master Control</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="text-zinc-400 hover:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Admin Navigation -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
                <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-zinc-500">Core Management</div>

                <!-- Admin Dashboard -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-lime-500/10 text-lime-400 border border-lime-500/30' : 'text-zinc-300 hover:bg-zinc-900/80 hover:text-white' }}"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Overview Stats</span>
                </a>

                <!-- Investment Plans Management -->
                <a 
                    href="#admin-plans" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Manage Plans</span>
                </a>

                <!-- User Management -->
                <a 
                    href="#admin-users" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Investors List</span>
                </a>

                <div class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-wider text-zinc-500">Financial Control</div>

                <!-- Deposit Approvals -->
                <a 
                    href="#admin-deposits" 
                    class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Deposit Requests</span>
                    </div>
                    <span class="rounded-full bg-lime-500/20 px-2 py-0.5 text-[10px] font-bold text-lime-400">0</span>
                </a>

                <!-- Withdrawal Approvals -->
                <a 
                    href="#admin-withdrawals" 
                    class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Withdraw Requests</span>
                    </div>
                    <span class="rounded-full bg-rose-500/20 px-2 py-0.5 text-[10px] font-bold text-rose-400">0</span>
                </a>

                <!-- Financial Ledger / Transactions -->
                <a 
                    href="#admin-transactions" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>System Ledger</span>
                </a>
            </div>

            <!-- Admin Switch to Investor View & Logout -->
            <div class="border-t border-zinc-800/80 p-4 space-y-2">
                <a href="{{ route('user.dashboard') }}" class="flex items-center justify-center space-x-2 w-full rounded-xl border border-zinc-800 bg-zinc-900/60 py-2 text-xs font-semibold text-zinc-300 hover:bg-zinc-800 hover:text-white transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Switch to Investor View</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center space-x-2 w-full rounded-xl bg-rose-600/10 border border-rose-500/20 py-2 text-xs font-semibold text-rose-300 hover:bg-rose-600/20 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Topbar Header -->
            <header class="flex h-20 items-center justify-between border-b border-zinc-800/80 bg-zinc-950/80 px-6 backdrop-blur-xl">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true" class="text-zinc-400 hover:text-white lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-white tracking-tight">@yield('page_title', 'Master Overview')</h1>
                        <p class="text-xs text-zinc-400">System Management & Real-time Operations</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center rounded-xl bg-lime-500/10 border border-lime-500/20 px-3 py-1.5 text-xs font-bold text-lime-400">
                        Admin Mode: Active
                    </span>
                </div>
            </header>

            <!-- Admin Body -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                @include('partials.alerts')

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
