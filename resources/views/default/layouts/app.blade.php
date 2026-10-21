<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'HIP HIP') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false }" class="min-h-screen bg-zinc-950 font-sans text-zinc-200 antialiased selection:bg-lime-500 selection:text-zinc-950">
    <!-- Ambient Background Lighting (Lime & Zinc Glow) -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-32 left-1/4 h-96 w-96 rounded-full bg-lime-500/10 blur-[140px]"></div>
        <div class="absolute top-1/3 right-10 h-80 w-80 rounded-full bg-zinc-800/40 blur-[130px]"></div>
        <div class="absolute bottom-10 left-10 h-72 w-72 rounded-full bg-lime-600/5 blur-[120px]"></div>
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

        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-zinc-800/80 bg-zinc-950/95 backdrop-blur-xl transition-transform duration-300 ease-in-out lg:static"
        >
            <!-- Sidebar Header & Logo -->
            <div class="flex h-20 items-center justify-between px-6 border-b border-zinc-800/60">
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-lime-400 via-lime-500 to-lime-600 p-[2px] shadow-md shadow-lime-500/20 group-hover:scale-105 transition-transform">
                        <div class="h-full w-full bg-zinc-950 rounded-[10px] flex items-center justify-center">
                            <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-white block">HIP <span class="text-lime-400">HIP</span></span>
                        <span class="text-[9px] uppercase tracking-widest text-zinc-400 font-semibold">Investor Portal</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="text-zinc-400 hover:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
                <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-zinc-500">Main Menu</div>

                <!-- Dashboard -->
                <a 
                    href="{{ route('user.dashboard') }}" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('user.dashboard') ? 'bg-lime-500/10 text-lime-400 border border-lime-500/30' : 'text-zinc-300 hover:bg-zinc-900/80 hover:text-white' }}"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Investment Plans -->
                <a 
                    href="#plans" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Investment Plans</span>
                </a>

                <!-- My Investments -->
                <a 
                    href="#my-investments" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>My Investments</span>
                </a>

                <div class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-wider text-zinc-500">Finance Operations</div>

                <!-- My Wallets & Transfer -->
                <a 
                    href="{{ route('user.wallets') }}" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('user.wallets') ? 'bg-lime-500/10 text-lime-400 border border-lime-500/30' : 'text-zinc-300 hover:bg-zinc-900/80 hover:text-white' }}"
                >
                    <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>My Wallets</span>
                </a>

                <!-- Deposit Funds -->
                <a 
                    href="#deposit" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    <span>Deposit Money</span>
                </a>

                <!-- Withdraw Funds -->
                <a 
                    href="#withdraw" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                    <span>Withdraw Funds</span>
                </a>

                <!-- Referral Network -->
                <a 
                    href="#referrals" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-zinc-300 hover:bg-zinc-900/80 hover:text-white transition-all"
                >
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Referral Network</span>
                </a>

                <!-- Transactions -->
                <a 
                    href="{{ route('user.transactions') }}" 
                    class="flex items-center space-x-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('user.transactions') ? 'bg-lime-500/10 text-lime-400 border border-lime-500/30' : 'text-zinc-300 hover:bg-zinc-900/80 hover:text-white' }}"
                >
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Transactions</span>
                </a>
            </div>

            <!-- User Info & Logout at Bottom -->
            <div class="border-t border-zinc-800/80 p-4">
                <div class="flex items-center justify-between rounded-xl bg-zinc-900/80 p-3 border border-zinc-800/60">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-lime-500/10 text-lime-400 font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="truncate text-xs font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-[10px] text-zinc-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 text-zinc-400 hover:text-rose-400 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
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
                        <h1 class="text-lg font-bold text-white tracking-tight">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-xs text-zinc-400 hidden sm:block">Welcome back, {{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Topbar Actions -->
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 rounded-xl border border-lime-500/20 bg-lime-500/10 px-3 py-1.5 text-xs font-medium text-lime-400">
                        <span class="h-2 w-2 rounded-full bg-lime-400 animate-pulse"></span>
                        <span>Account Verified</span>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl border border-zinc-700 bg-zinc-800 px-3 py-1.5 text-xs font-semibold text-zinc-300 hover:bg-zinc-700 hover:text-white transition-all">
                            Admin Panel &rarr;
                        </a>
                    @endif
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                @include('partials.alerts')

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
