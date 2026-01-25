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
