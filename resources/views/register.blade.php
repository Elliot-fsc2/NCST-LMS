<x-guest-layout>
    <x-slot name="title">Sign Up - {{ config('app.name') }}</x-slot>

    <div>
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-white">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Join us to start your learning journey.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Full Name
            </label>
            <div class="mt-1">
                <input id="name" name="name" type="text" autocomplete="name" required autofocus
                    value="{{ old('name') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition"
                    placeholder="Enter your full name" />
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email
            </label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                    value="{{ old('email') }}"
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
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition"
                    placeholder="Create a password" />
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Confirm Password
            </label>
            <div class="mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" required
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition"
                    placeholder="Confirm your password" />
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms -->
        <div class="flex items-start">
            <input type="checkbox" name="terms" id="terms" required
                class="mt-0.5 h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-violet-600 focus:ring-violet-500" />
            <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                I agree to the
                <a href="#" class="text-violet-600 hover:text-violet-500 font-medium">Terms of Service</a>
                and
                <a href="#" class="text-violet-600 hover:text-violet-500 font-medium">Privacy Policy</a>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center rounded-lg bg-violet-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition">
                Create Account
            </button>
        </div>

        <!-- Login Link -->
        @if (Route::has('login'))
            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:text-violet-500 transition">
                    Sign in
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
