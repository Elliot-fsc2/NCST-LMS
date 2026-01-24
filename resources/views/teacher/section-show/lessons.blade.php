@php
    $lessons = $section->lessons;
@endphp

<div>
    @if ($lessons->isEmpty())
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-book-open class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No lessons yet</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                Lessons for this course will appear here once they are added.
            </p>
        </div>
    @else
        <!-- Lessons List -->
        <div class="space-y-3 md:space-y-4">
            @foreach ($lessons as $lesson)
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start gap-2 md:gap-3 mb-2">
                                <div
                                    class="flex items-center justify-center w-8 h-8 md:w-10 md:h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 shrink-0">
                                    <x-heroicon-o-book-open
                                        class="w-4 h-4 md:w-5 md:h-5 text-[#204ab5] dark:text-blue-400" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm md:text-lg font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $lesson->title }}
                                    </h3>
                                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                        Added {{ $lesson->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if ($lesson->description)
                                <p class="mt-3 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                    {{ $lesson->description }}
                                </p>
                            @endif

                            @if ($lesson->content)
                                <div class="mt-4 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <x-heroicon-o-document-text class="w-4 h-4" />
                                    <span>Has content</span>
                                </div>
                            @endif

                            @if ($lesson->file_path)
                                <div class="mt-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <x-heroicon-o-paper-clip class="w-4 h-4" />
                                    <span>Has attachment</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $lesson->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
