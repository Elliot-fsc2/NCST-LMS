<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">My Sections</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Manage your class sections and view enrolled students.
        </p>
    </div>

    @if ($sections->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-12 text-center">
            <div
                class="mx-auto w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-academic-cap class="w-8 h-8 text-gray-400" />
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No sections assigned</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                You haven't been assigned to any sections yet.
            </p>
        </div>
    @else
        <!-- Sections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($sections as $section)
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Card Header with Course Color -->
                    <div class="h-2 bg-gradient-to-r from-[#204ab5] to-blue-600"></div>

                    <div class="p-6">
                        <!-- Section Info -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $section->name }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $section->course->name ?? 'No Course' }}
                                </p>
                                @if ($section->course?->code)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 mt-2 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                        {{ $section->course->code }}
                                    </span>
                                @endif
                            </div>
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                                <x-heroicon-o-academic-cap class="w-6 h-6 text-[#204ab5] dark:text-blue-400" />
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center gap-4 py-4 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-50 dark:bg-green-900/20">
                                    <x-heroicon-o-user-group class="w-4 h-4 text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $section->students_count }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ Str::plural('Student', $section->students_count) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                            <a href="#"
                                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-medium text-white bg-[#204ab5] hover:bg-[#1a3d94] rounded-lg transition-colors duration-200">
                                <x-heroicon-o-eye class="w-4 h-4" />
                                View Section
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary Stats -->
        <div class="mt-8 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-[#204ab5] dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Sections</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $sections->count() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20">
                        <x-heroicon-o-users class="w-5 h-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Students</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $sections->sum('students_count') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
