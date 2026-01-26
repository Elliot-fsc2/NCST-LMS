<?php

use App\Models\Section;
use Livewire\Component;

new class extends Component {
    public Section $section;

    public function mount(): void
    {
        $this->section->load(['students.user', 'lessons', 'quizzes', 'news.teacher', 'course']);
    }
};
?>

<x-slot name="title">{{ $section->name }}</x-slot>
<x-slot name="header">{{ $section->name }}</x-slot>

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-6">
            <a href="{{ route('teacher.manage-sections') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                Sections
            </a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 dark:text-white font-medium">{{ $section->name }}</span>
        </nav>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Section Header -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $section->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Course: <span
                            class="font-medium text-gray-900 dark:text-white">{{ $section->course->name }}</span>
                    </p>
                </div>

                <!-- News Section -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">News & Announcements</h3>
                    </div>

                    @forelse ($section->news as $newsItem)
                        <div
                            class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $newsItem->title }}
                                </h4>
                                <span class="text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $newsItem->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                                {{ $newsItem->content }}
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Posted by {{ $newsItem->teacher->user->name }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">No announcements yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Aside/Sidebar (Right) -->
            <aside class="lg:col-span-1 space-y-4">
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
                            <span class="text-sm text-gray-600 dark:text-gray-400">Lessons</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->lessons->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Students</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->students->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Quizzes</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->quizzes->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Students -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Students</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2 max-h-80 overflow-y-auto">
                        @forelse ($section->students->take(10) as $student)
                            <div class="flex items-center gap-2 py-1.5">
                                <div
                                    class="w-7 h-7 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-xs font-medium text-gray-700 dark:text-gray-300">
                                    {{ substr($student->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700 dark:text-gray-300 flex-1 truncate">
                                    {{ $student->user->name }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 py-2">None</p>
                        @endforelse
                    </div>
                </div>

                <!-- Announcements -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Announcements</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        @forelse ($section->news->take(3) as $newsItem)
                            <div class="py-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $newsItem->title }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">None</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
