<x-auth-layout>
    <x-slot name="title">Teacher Dashboard - {{ config('app.name') }}</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Welcome back, {{ Auth::user()->profile?->first_name }}!
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Manage your courses and track student progress.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Courses</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">8</p>
                        </div>

                    </div>
                </div>

                <!-- Total Students -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Students</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">124</p>
                        </div>

                    </div>
                </div>

                <!-- Assignments -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Assignments</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">15</p>
                        </div>

                    </div>
                </div>

                <!-- Pending Reviews -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">7</p>
                        </div>

                    </div>
                </div>


            </div>
            <div x-data="{
                count: 0
            }"
            class="flex justify-center items-center flex-col bg-white dark:bg-gray-900 pb-5 rounded-lg border border-gray-200 dark:border-gray-800">
                <button @click="count++"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Clicked <span x-text="count"></span> times
                </button>

                <template x-if="count % 5 === 0 && count !== 0">
                    <p class="mt-2 text-green-600 font-bold block">You've reached a multiple of 5!</p>
                </template>
            </div>
        </div>
    </div>
</x-auth-layout>
