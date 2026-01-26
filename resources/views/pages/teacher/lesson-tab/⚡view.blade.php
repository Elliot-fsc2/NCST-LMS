<?php

use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('components.auth-layout')]
class extends Component
{
    public Lesson $lesson;

    public function mount(Lesson $lesson): void
    {
        Gate::authorize('view', $lesson);

        $this->lesson = $lesson->load('section.course');
    }
};
?>

<x-slot name="title">{{ $lesson->title }} - {{ config('app.name') }}</x-slot>
<x-slot name="header">{{ $lesson->title }}</x-slot>
<x-slot name="subheader">{{ $lesson->section->course->code }} - {{ $lesson->section->name }}</x-slot>

<div>
    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('teacher.sections.show', $lesson->section) }}" wire:navigate
                class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                {{ $lesson->section->name }}
            </a>
            <x-heroicon-o-chevron-right class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white font-medium">{{ $lesson->title }}</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Lesson Hero Card -->
            <div
                class="bg-linear-to-br from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-900 rounded-xl p-6 md:p-8 text-white shadow-lg">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                                {{ $lesson->section->course->code }}
                            </span>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                                {{ $lesson->section->name }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $lesson->title }}</h1>
                        <p class="text-blue-100 text-sm">Last updated {{ $lesson->updated_at->diffForHumans() }}</p>
                    </div>
                    @can('update', $lesson)
                        <a href="{{ route('teacher.lesson.edit', ['section' => $lesson->section, 'lesson' => $lesson]) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white text-sm font-medium rounded-lg transition-all hover:scale-105">
                            <x-heroicon-o-pencil class="w-4 h-4" />
                            <span>Edit Lesson</span>
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Lesson Content Card -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Lesson Content</h2>
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <div
                        class="prose dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-strong:text-gray-900 dark:prose-strong:text-white prose-code:text-blue-600 dark:prose-code:text-blue-400 prose-pre:bg-gray-100 dark:prose-pre:bg-gray-800">
                        <div class="text-base leading-relaxed whitespace-pre-wrap">{{ $lesson->content }}</div>
                    </div>
                </div>
            </div>

            <!-- File Attachment -->
            @if ($lesson->file_path)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                    <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4">
                        <div class="flex items-center gap-3">

                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Learning Materials</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center justify-between p-5 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 border border-blue-200 dark:border-blue-800 rounded-xl hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ basename($lesson->title) }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <span>Uploaded {{ $lesson->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($lesson->file_path) }}"
                                download="{{ basename($lesson->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all hover:scale-105 shadow-md">
                                <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Course Info Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden top-6">
                <div
                    class="bg-linear-to-r from-indigo-600 to-purple-600 dark:from-indigo-700 dark:to-purple-800 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        Course Details
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                            Course</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $lesson->section->course->code }}</p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-800 pt-4">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                            Section</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lesson->section->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Lesson Metadata -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        Lesson Information
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $lesson->created_at->format('M j, Y') }}
                                </dd>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $lesson->updated_at->format('M j, Y') }}
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
</div>