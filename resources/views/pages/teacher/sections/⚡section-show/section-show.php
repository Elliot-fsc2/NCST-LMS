<?php

use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('components.auth-layout')]
class extends Component
{
    public Section $section;

    #[Url]
    public string $tab = 'lessons';

    public function mount(Section $section): void
    {
        Gate::authorize('view', $section);

        $this->section = $section;
    }

    public function with(): array
    {
        match ($this->tab) {
            'students' => $this->section->load(['course', 'teacher.user', 'students.user']),
            'lessons' => $this->section->load(['course', 'teacher.user', 'lessons']),
            'teachers' => $this->section->load(['course', 'teacher.user']),
            default => $this->section->load(['course', 'teacher.user']),
        };

        return [
            'activeTab' => $this->tab,
            'section' => $this->section,
        ];
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }
};
