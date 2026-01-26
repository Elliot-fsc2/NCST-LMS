<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public $student;

    public $sections;

    public $latestNews;

    public function mount(): void
    {
        $user = Auth::user();
        $this->student = $user->profile;

        if ($this->student) {
            $this->student->load('course');
            $this->sections = $this->student->sections()->with('course')->get();

            $this->latestNews = \App\Models\News::query()
                ->whereIn('section_id', $this->sections->pluck('id'))
                ->with(['section.course', 'teacher.user'])
                ->latest()
                ->take(10)
                ->get();
        } else {
            $this->sections = collect();
            $this->latestNews = collect();
        }
    }
};
?>

<x-slot name="title">Home</x-slot>
<x-slot name="header">Home</x-slot>
<x-slot name="subheader">Welcome to your student dashboard. Here you can view your sections and latest
    announcements.</x-slot>

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-800">
                        <h2 class="text-base font-semibold text-gray-900 dark:text-white">Latest Announcements</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($latestNews as $news)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                                {{ $news->title }}
                                            </h3>
                                            <span
                                                class="px-2 py-0.5 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full whitespace-nowrap">
                                                {{ $news->section->course->name }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-2">
                                            {{ $news->content }}
                                        </p>
                                        <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-user-circle class="w-3.5 h-3.5" />
                                                <span>{{ $news->teacher->user->name }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-academic-cap class="w-3.5 h-3.5" />
                                                <span>{{ $news->section->name }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                                <span>{{ $news->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <x-heroicon-o-newspaper
                                    class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">No announcements yet</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Check back later for updates
                                    from your teachers</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Aside/Sidebar (Right) -->
            <aside class="lg:col-span-1 space-y-4">
                <!-- Student Info -->
                @if ($student)
                    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">My Profile</h3>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Student Number</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->student_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Course</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $student->course->name }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- My Sections -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">My Sections</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse ($sections as $section)
                            <a href="{{ route('student.sections.view', $section) }}" wire:navigate
                                class="block p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-all">
                                <div class="flex items-start gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $section->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                            {{ $section->course->name }}
                                        </p>
                                    </div>
                                    <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" />
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-6">
                                <x-heroicon-o-academic-cap
                                    class="w-10 h-10 mx-auto text-gray-400 dark:text-gray-600 mb-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">No sections yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Statistics</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sections</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $sections->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Announcements</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $latestNews->count() }}</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
