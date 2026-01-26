<?php

use App\Models\Section;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

new class extends Component {
    public Section $section;

    #[On('section.lessons.updated')]
    #[Computed]
    public function lessons()
    {
        return $this->section->lessons()->latest()->get();
    }
};
?>

<div>
    <!-- Add Lesson Button -->
    <div class="mb-4 md:mb-6 flex justify-end">
        <a href="{{ route('teacher.lesson.create', $section) }}" wire:navigate
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
            <x-heroicon-o-plus class="w-5 h-5" />
            <span>Create Lesson</span>
        </a>
    </div>

    @if ($this->lessons->isEmpty())
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-book-open class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No lessons yet</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                Get started by creating your first lesson.
            </p>
        </div>
    @else
        <!-- Lessons List -->
        <div class="space-y-3 md:space-y-4">
            @island(name: 'lessons')
                @foreach ($this->lessons as $lesson)
                    <a href="{{ route('teacher.lesson.view', ['section' => $section, 'lesson' => $lesson]) }}" wire:navigate
                        class="block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-2 md:gap-3 mb-2">
                                    <div class="min-w-0">
                                        <h3 class="text-sm md:text-lg font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $lesson->title }}
                                        </h3>
                                    </div>
                                </div>

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
                                    {{ $lesson->created_at->diffForHumans() }}
                                </span>
                                <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-400" />
                            </div>
                        </div>
                    </a>
                @endforeach
            @endisland
        </div>
    @endif
</div>
