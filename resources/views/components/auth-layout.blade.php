<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'LMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    {{-- <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> --}}

    <!-- Dark Mode Script - Must run before body renders to prevent flash -->
    <script>
        // This runs immediately to prevent flash of light mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles
    @livewireStyles

</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out"
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen }">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-center justify-center gap-3">
                        {{-- <div class="flex items-center justify-center w-10 h-10 rounded-xl">
                            <img src="{{ asset('images/logo.png') }}" alt="NCST Logo" class="w-8 h-8 object-contain" />
                        </div> --}}
                        <span class="text-xl font-bold text-gray-900 dark:text-white">LMS</span>
                    </div>
                    <button @click="sidebarOpen = false"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4 space-y-1 z-0">
                    <a href="{{ route(Auth::user()->role . '.home') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs(Auth::user()->role . '.home') ? 'bg-[#204ab5] text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition">
                        <x-heroicon-o-home class="w-5 h-5" />
                        <span>Home</span>
                    </a>

                    @if (Auth::user()->role === 'teacher')
                        <a href="{{ route('teacher.sections') }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('teacher.sections', 'teacher.sections.*', 'teacher.lesson.*') ? 'bg-[#204ab5] text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition">
                            <x-heroicon-o-academic-cap class="w-5 h-5" />
                            <span>My Sections</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-user-group class="w-5 h-5" />
                            <span>Students</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-chart-bar class="w-5 h-5" />
                            <span>Grades</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-calendar class="w-5 h-5" />
                            <span>Calendar</span>
                        </a>

                        @if (Auth::user()->profile?->is_department_head)
                            <!-- System Navigation Group -->
                            <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-800">
                                <div class="px-4 mb-2">
                                    <h3
                                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        System
                                    </h3>
                                </div>

                                <a href="{{ route('teacher.manage-sections') }}" wire:navigate
                                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('teacher.manage-sections', 'teacher.manage-sections.*') ? 'bg-[#204ab5] text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition">
                                    <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                                    <span>Manage Sections</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-book-open class="w-5 h-5" />
                            <span>Academic</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-clock class="w-5 h-5" />
                            <span>Class Routine</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-newspaper class="w-5 h-5" />
                            <span>News</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-calendar class="w-5 h-5" />
                            <span>Calendar</span>
                        </a>
                    @endif
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                    <div
                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition cursor-pointer">
                        <div class="relative shrink-0">
                            <div
                                class="w-10 h-10 rounded-full bg-linear-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>

                            <div
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">View Account</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition"
                                title="Log Out">
                                <x-heroicon-o-arrow-right-start-on-rectangle class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col lg:ml-64 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-40">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-bars-3 class="w-6 h-6" />
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $header ?? 'Dashboard' }}
                            </h1>
                            @isset($subheader)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 hidden md:block">
                                    {{ $subheader }}
                                </p>
                            @endisset
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Messages Button -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 text-gray-500" />
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#204ab5] rounded-full"></span>
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <x-heroicon-o-bell class="w-5 h-5 text-gray-500" />
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Badge (Mobile) -->
                        {{-- <div
                            class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20">
                            <span
                                class="text-xs font-medium text-blue-700 dark:text-blue-400">{{ ucfirst(Auth::user()->role) }}</span>
                        </div> --}}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-950">
                <div class="p-4 lg:p-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display: none;"></div>

    @livewire('notifications')
    @livewireScripts
    @filamentScripts
</body>

</html>
