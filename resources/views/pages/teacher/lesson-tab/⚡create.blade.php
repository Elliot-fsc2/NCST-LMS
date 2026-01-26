<?php

use App\Models\Lesson;
use App\Models\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('components.auth-layout')]
class extends Component
{
    use WithFileUploads;

    public Section $section;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $content = '';

    #[Validate('nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,jpg,jpeg,png,txt')]
    public $file = null;

    public function mount(Section $section): void
    {
        Gate::authorize('create', Lesson::class);

        // Verify teacher owns this section
        if ($section->teacher_id !== auth()->user()->profile->id) {
            abort(404);
        }

        $this->section = $section;
    }

    public function save(): void
    {
        $this->validate();

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('lessons', 'public');
        }

        Lesson::create([
            'title' => $this->title,
            'content' => $this->content,
            'section_id' => $this->section->id,
            'file_path' => $filePath,
        ]);

        Notification::make()
            ->title('Lesson created successfully!')
            ->success()
            ->send();

        $this->redirect(route('teacher.sections.show', [
            'section' => $this->section,
            'tab' => 'lessons',
        ]), navigate: true);
    }
};
?>

<x-slot name="title">{{ $section->name }} - {{ config('app.name') }}</x-slot>
<x-slot name="header">Create New Lesson</x-slot>
<x-slot name="subheader">{{ $section->course->code }} - {{ $section->name }}</x-slot>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 md:mb-8">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'lessons']) }}" wire:navigate
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Create New Lesson</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $section->course->name }} - {{ $section->name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="save" class="space-y-6">
        <!-- Lesson Title -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Lesson Title <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" wire:model="title"
                class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                placeholder="Enter lesson title">
            @error('title')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Lesson Content -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Lesson Content <span class="text-red-500">*</span>
            </label>
            <textarea id="content" wire:model="content" rows="12"
                class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                placeholder="Enter lesson content..."></textarea>
            @error('content')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Attachment -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                File Attachment
            </label>
            <div class="mt-1">
                <input type="file" id="file" wire:model="file"
                    class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-950 focus:outline-none">
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Supported files: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, JPG, JPEG, PNG (Max: 10MB)
                </p>
            </div>
            @error('file')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror

            <!-- Loading Indicator for File Upload -->
            <div wire:loading wire:target="file" class="mt-3">
                <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Uploading...</span>
                </div>
            </div>

            <!-- File Preview -->
            @if ($file)
                <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-paper-clip class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                            <span
                                class="text-sm text-gray-700 dark:text-gray-300">{{ $file->getClientOriginalName() }}</span>
                        </div>
                        <button type="button" wire:click="$set('file', null)"
                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'lessons']) }}" wire:navigate
                class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Cancel
            </a>
            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <span wire:loading.remove wire:target="save">Create Lesson</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>