<div>
    @if ($section->teacher)
        <!-- Teacher Info Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div
                class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <h3 class="text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                    Section Instructor
                </h3>
            </div>

            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row items-start gap-4 md:gap-6">
                    <!-- Avatar -->
                    <div
                        class="flex items-center justify-center w-16 h-16 md:w-20 md:h-20 rounded-full bg-linear-to-br from-[#204ab5] to-blue-600 text-white font-bold text-xl md:text-2xl shrink-0">
                        {{ strtoupper(substr($section->teacher->user->name ?? 'T', 0, 1)) }}
                    </div>

                    <!-- Teacher Details -->
                    <div class="flex-1 min-w-0">
                        <h4 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white truncate">
                            {{ $section->teacher->user->name ?? 'Unknown Teacher' }}
                        </h4>

                        <div class="mt-3 md:mt-4 space-y-2 md:space-y-3">
                            @if ($section->teacher->user->email)
                                <div class="flex items-center gap-2 md:gap-3 text-xs md:text-sm">
                                    <div
                                        class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-gray-100 dark:bg-gray-800 shrink-0">
                                        <x-heroicon-o-envelope
                                            class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-600 dark:text-gray-400" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-gray-500 dark:text-gray-400">Email</p>
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $section->teacher->user->email }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($section->teacher->department_id)
                                <div class="flex items-center gap-2 md:gap-3 text-xs md:text-sm">
                                    <div
                                        class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-gray-100 dark:bg-gray-800 shrink-0">
                                        <x-heroicon-o-building-office
                                            class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-600 dark:text-gray-400" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-gray-500 dark:text-gray-400">Department</p>
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $section->teacher->department->name ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-academic-cap class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No teacher assigned</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                This section doesn't have an assigned teacher yet.
            </p>
        </div>
    @endif
</div>
