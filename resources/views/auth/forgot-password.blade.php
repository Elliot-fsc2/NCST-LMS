<x-guest-layout>
    <x-slot name="title">Reset Password - {{ config('app.name') }}</x-slot>

    <div>
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-white">Forgot Password?</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            No problem. Just let us know your email address and we'll email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-sm text-green-800 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email
            </label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required autofocus
                    value="{{ old('email') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition"
                    placeholder="Enter your email" />
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center rounded-lg bg-violet-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
                Email Password Reset Link
            </button>
        </div>

        <!-- Back to Login -->
        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:text-violet-500 transition">
                Back to sign in
            </a>
        </p>
    </form>
</x-guest-layout>
