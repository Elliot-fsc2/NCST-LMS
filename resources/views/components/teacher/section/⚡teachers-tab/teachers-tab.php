<?php

use App\Models\Section;
use Livewire\Component;

new class extends Component
{
    public Section $section;

    public function mount(Section $section): void
    {
        $this->section = $section->load('teacher.user', 'teacher.department');
    }
};
