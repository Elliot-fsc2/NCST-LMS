@php
    $announcements = collect();
@endphp

<div>
    @if ($announcements->isEmpty())
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-newspaper class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No announcements yet</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                News and announcements for this section will appear here.
            </p>
            <div class="mt-6">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs md:text-sm font-medium text-white bg-[#204ab5] hover:bg-[#1a3d94] rounded-lg transition-colors duration-200">
                    <x-heroicon-o-plus class="w-4 h-4 md:w-5 md:h-5" />
                    Create Announcement
                </button>
            </div>
        </div>
    @else
        <!-- Announcements List -->
        <div class="space-y-3 md:space-y-4">
            @foreach ($announcements as $announcement)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 shrink-0">
                            <x-heroicon-o-megaphone class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $announcement->title }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                {{ $announcement->content }}
                            </p>
                            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                Posted {{ $announcement->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
