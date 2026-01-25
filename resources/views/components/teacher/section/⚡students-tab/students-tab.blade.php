<div>
    @if ($section->students->isEmpty())
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-user-group class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No students enrolled</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                Students enrolled in this section will appear here.
            </p>
        </div>
    @else
        <!-- Students Grid -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <!-- Stats Header -->
            <div
                class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                        Enrolled Students
                    </h3>
                    <span
                        class="inline-flex items-center px-2 md:px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                        {{ $section->students->count() }} {{ Str::plural('Student', $section->students->count()) }}
                    </span>
                </div>
            </div>

            <!-- Students List -->
            <div class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($section->students as $student)
                    <div class="px-4 md:px-6 py-3 md:py-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 md:gap-4 min-w-0 flex-1">
                                <!-- Avatar -->
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-linear-to-br from-[#204ab5] to-blue-600 text-white font-semibold text-sm">
                                    {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                                </div>

                                <!-- Student Info -->
                                <div class="min-w-0">
                                    <h4 class="text-xs md:text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $student->user->name ?? 'Unknown' }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $student->user->email ?? 'No email' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 shrink-0">
                                <button
                                    class="p-1.5 md:p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                    <x-heroicon-o-eye class="w-4 h-4 md:w-5 md:h-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
