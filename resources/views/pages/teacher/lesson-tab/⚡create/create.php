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
