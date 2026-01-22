<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'NCST LMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-white antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding & Illustration -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#204ab5] relative overflow-hidden">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-30">
            </div>

            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <div>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'NCST LMS') }} Logo"
                            class="w-10 h-10 rounded" />
                        <span class="text-2xl font-bold text-white">{{ config('app.name', 'NCST LMS') }}</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <h1 class="text-4xl font-bold text-white leading-tight">
                        Welcome to Your Learning Journey
                    </h1>
                    <p class="text-lg text-white/90 max-w-md">
                        Access your courses, track your progress, and connect with teachers and students all in one
                        place.
                    </p>
                </div>

                <div class="text-sm text-white/70">
                    © {{ date('Y') }} NCST. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side - Form Content -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md space-y-8">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-3 mb-8">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'NCST LMS') }} Logo" class="w-10 h-10 rounded" />
                   
                    <span
                        class="text-xl font-bold text-[#1b1b18] dark:text-white">{{ config('app.name', 'NCST LMS') }}</span>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
