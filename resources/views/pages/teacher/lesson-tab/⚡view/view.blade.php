<x-slot name="title">{{ $lesson->title }} - {{ config('app.name') }}</x-slot>
<x-slot name="header">{{ $lesson->title }}</x-slot>
<x-slot name="subheader">{{ $lesson->section->course->code }} - {{ $lesson->section->name }}</x-slot>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 md:mb-8">
        <div class="flex items-center justify-between mb-4">


            @can('update', $lesson)
                <a href="{{ route('teacher.lesson.edit', ['section' => $lesson->section, 'lesson' => $lesson]) }}"
                    wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    <x-heroicon-o-pencil class="w-4 h-4" />
                    <span>Edit</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- Lesson Details -->
    <div class="space-y-6">
        <!-- Content -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content</h2>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $lesson->content }}</p>
            </div>
        </div>

        <!-- File Attachment -->
        @if ($lesson->file_path)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Attachment</h2>
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                            <x-heroicon-o-paper-clip class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ basename($lesson->file_path) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Uploaded {{ $lesson->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($lesson->file_path) }}" download="{{ basename($lesson->file_path) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                        <span>Download</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Metadata -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Details</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $lesson->created_at->format('F j, Y \a\t g:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $lesson->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
