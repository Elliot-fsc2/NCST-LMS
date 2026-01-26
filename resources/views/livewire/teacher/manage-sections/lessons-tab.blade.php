<div class="space-y-4">
    @forelse ($section->lessons as $lesson)
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $lesson->title }}</h4>
                    @if ($lesson->content)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $lesson->content }}</p>
                    @endif
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <x-heroicon-o-clock class="w-4 h-4" />
                            {{ $lesson->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div
            class="bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400">No lessons yet.</p>
        </div>
    @endforelse
</div>
