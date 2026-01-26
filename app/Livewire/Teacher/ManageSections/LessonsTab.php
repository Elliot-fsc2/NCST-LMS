<?php

namespace App\Livewire\Teacher\ManageSections;

use App\Models\Section;
use Livewire\Component;

class LessonsTab extends Component
{
    public Section $section;

    public function mount(): void
    {
        $this->section->load(['lessons']);
    }

    public function render()
    {
        return view('livewire.teacher.manage-sections.lessons-tab');
    }
}
