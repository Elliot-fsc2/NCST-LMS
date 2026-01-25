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
        $section = $this->section;

        match ($this->tab) {
            'students' => $section->load(['course', 'teacher.user', 'students.user']),
            'lessons' => $section->load(['course', 'teacher.user', 'lessons']),
            'teachers' => $section->load(['course', 'teacher.user']),
            default => $section->load(['course', 'teacher.user']),
        };

        return [
            'section' => $section,
            'activeTab' => $this->tab,
        ];
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }
};
