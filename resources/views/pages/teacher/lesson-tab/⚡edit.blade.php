<?php

use App\Models\Lesson;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('components.auth-layout')]
class extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use WithFileUploads;

    public Lesson $lesson;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $content = '';

    #[Validate('nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,jpg,jpeg,png,txt')]
    public $file = null;

    public bool $removeExistingFile = false;

    public function mount(Lesson $lesson): void
    {
        Gate::authorize('update', $lesson);

        $this->lesson = $lesson->load('section.course');
        $this->title = $lesson->title;
        $this->content = $lesson->content;
    }

    public function removeFile(): void
    {
        $this->removeExistingFile = true;
    }

    public function cancelRemoveFile(): void
    {
        $this->removeExistingFile = false;
    }

    public function update(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        // Handle file upload
        if ($this->file) {
            // Delete old file if exists
            if ($this->lesson->file_path) {
                Storage::disk('public')->delete($this->lesson->file_path);
            }
            $data['file_path'] = $this->file->store('lessons', 'public');
        } elseif ($this->removeExistingFile && $this->lesson->file_path) {
            // Remove existing file
            Storage::disk('public')->delete($this->lesson->file_path);
            $data['file_path'] = null;
        }

        $this->lesson->update($data);

        Notification::make()
            ->title('Lesson updated successfully!')
            ->success()
            ->send();

        $this->redirect(route('teacher.lesson.view', ['section' => $this->lesson->section, 'lesson' => $this->lesson]), navigate: true);
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading('Delete Lesson')
            ->modalDescription('Are you sure you want to delete this lesson? This action cannot be undone.')
            ->modalSubmitActionLabel('Yes, delete it')
            ->action(function () {
                if ($this->lesson->file_path) {
                    Storage::disk('public')->delete($this->lesson->file_path);
                }

                $section = $this->lesson->section;
                $this->lesson->delete();

                Notification::make()
                    ->title('Lesson deleted successfully!')
                    ->success()
                    ->send();

                $this->redirect(route('teacher.sections.show', [
                    'section' => $section,
                    'tab' => 'lessons',
                ]), navigate: true);
            });
    }
};
?>

<x-slot name="title">Edit {{ $lesson->title }} - {{ config('app.name') }}</x-slot>
<x-slot name="header">Edit Lesson</x-slot>
<x-slot name="subheader">{{ $lesson->section->course->code }} - {{ $lesson->section->name }}</x-slot>
<div class="max-w-4xl mx-auto">

    <!-- Form -->
    <form wire:submit="update" class="space-y-6">
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
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                File Attachment
            </label>

            <!-- Existing File -->
            @if ($lesson->file_path && !$removeExistingFile)
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                                <x-heroicon-o-paper-clip class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ basename($lesson->file_path) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Current attachment</p>
                            </div>
                        </div>
                        <button type="button" wire:click="removeFile"
                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                            Remove
                        </button>
                    </div>
                </div>
            @elseif ($removeExistingFile)
                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">File will be removed when you save
                            </p>
                        </div>
                        <button type="button" wire:click="cancelRemoveFile"
                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                            Undo
                        </button>
                    </div>
                </div>
            @endif

            <!-- Upload New File -->
            <div class="mt-1">
                <input type="file" id="file" wire:model="file"
                    class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-950 focus:outline-none">
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    @if ($lesson->file_path && !$removeExistingFile)
                        Upload a new file to replace the existing one.
                    @else
                        Supported files: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, JPG, JPEG, PNG (Max: 10MB)
                    @endif
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

            <!-- New File Preview -->
            @if ($file)
                <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-paper-clip class="w-4 h-4 text-green-600 dark:text-green-400" />
                            <span
                                class="text-sm text-green-700 dark:text-green-300">{{ $file->getClientOriginalName() }}</span>
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
        <div class="flex items-center justify-between pt-4">
            {{ ($this->deleteAction)(['lesson' => $lesson->id]) }}

            <div class="flex items-center gap-3">
                <a href="{{ route('teacher.lesson.view', ['section' => $lesson->section, 'lesson' => $lesson]) }}"
                    wire:navigate
                    class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="update"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <span wire:loading.remove wire:target="update">Update Lesson</span>
                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Updating...
                    </span>
                </button>
            </div>
        </div>
    </form>
    <x-filament-actions::modals />
</div>