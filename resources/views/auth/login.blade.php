<x-guest-layout>
    <x-slot name="title">Sign In - {{ config('app.name') }}</x-slot>

    <div>
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-white">Sign In</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Welcome back! Please enter your details.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-sm text-green-800 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email
            </label>
            <div class="mt-1">
                <input id="email" name="email" autocomplete="email" autofocus
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition"
                    placeholder="Enter your email" />
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-[#204ab5] focus:ring-2 focus:ring-[#204ab5]/20 transition"
                    placeholder="Enter your password" />
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-[#204ab5] focus:ring-[#204ab5]" />
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-[#204ab5] hover:text-[#1a3d96] transition">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center rounded-lg bg-[#204ab5] px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#1a3d96] focus:outline-none focus:ring-2 focus:ring-[#204ab5] focus:ring-offset-2 transition">
                Sign in
            </button>
        </div>
    </form>
</x-guest-layout>
