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

    public function downloadFile(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (!$this->lesson->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($this->lesson->file_path);
    }
};
