<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication') - {{ config('app.name', 'HIP HIP') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#070b14] font-sans text-slate-200 antialiased selection:bg-emerald-500 selection:text-white relative overflow-x-hidden flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Ambient Background Glow Effects -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 h-[500px] w-[700px] rounded-full bg-gradient-to-tr from-emerald-600/15 via-teal-500/10 to-indigo-600/15 blur-[120px]"></div>
        <div class="absolute bottom-0 right-10 h-72 w-72 rounded-full bg-emerald-500/10 blur-[100px]"></div>
        <div class="absolute top-1/2 left-10 h-64 w-64 rounded-full bg-indigo-500/10 blur-[100px]"></div>
    </div>

    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Brand Logo Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-3 group">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-400 to-cyan-500 p-[2px] shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform duration-300">
                    <div class="h-full w-full bg-[#0a0f1d] rounded-[14px] flex items-center justify-center">
                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-bold tracking-tight text-white block">HIP <span class="text-emerald-400">HIP</span></span>
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold">HYIP Investment Engine</span>
                </div>
            </a>
        </div>

        <!-- Auth Card Container -->
        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-8 shadow-2xl backdrop-blur-xl sm:p-10">
            @include('partials.alerts')

            @yield('content')
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'HIP HIP') }}. High-Yield Wealth Generation Platform.
        </div>
    </div>
</body>
</html>
