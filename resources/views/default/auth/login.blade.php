@extends('layouts.auth')

@section('title', 'Sign In to Your Account')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Investor Login</h2>
        <p class="text-xs text-zinc-400 mt-1">Access your investment portfolios and real-time ROI yields.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-zinc-300 mb-1.5">
                Email Address
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-zinc-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="investor@example.com"
                    class="w-full rounded-xl border border-zinc-800 bg-zinc-950/80 py-2.5 pl-10 pr-4 text-sm text-white placeholder-zinc-500 transition-all focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500"
                >
            </div>
        </div>

        <!-- Password Field -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-zinc-300">
                    Password
                </label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-lime-400 hover:text-lime-300 transition-colors">
                    Forgot password?
                </a>
            </div>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-zinc-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full rounded-xl border border-zinc-800 bg-zinc-950/80 py-2.5 pl-10 pr-4 text-sm text-white placeholder-zinc-500 transition-all focus:border-lime-500 focus:outline-none focus:ring-1 focus:ring-lime-500"
                >
            </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2 text-xs text-zinc-400 cursor-pointer select-none">
                <input
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-zinc-700 bg-zinc-900 text-lime-500 focus:ring-lime-500/20"
                >
                <span>Remember this device</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button
                type="submit"
                class="w-full flex items-center justify-center space-x-2 rounded-xl bg-lime-500 hover:bg-lime-400 px-4 py-3 font-bold text-zinc-950 shadow-lg shadow-lime-500/20 transition-all hover:shadow-lime-500/30 hover:scale-[1.01] active:scale-[0.99]"
            >
                <span>Sign In to Dashboard</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>

    <div class="mt-6 border-t border-zinc-800/80 pt-5 text-center">
        <p class="text-xs text-zinc-400">
            Don't have an investment account yet?
            <a href="{{ route('register') }}" class="font-semibold text-lime-400 hover:text-lime-300 transition-colors">
                Create Account
            </a>
        </p>
    </div>
@endsection
