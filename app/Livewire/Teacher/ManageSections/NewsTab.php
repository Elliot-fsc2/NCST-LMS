<?php

namespace App\Livewire\Teacher\ManageSections;

use App\Models\Section;
use Livewire\Component;

class NewsTab extends Component
{
    public Section $section;

    public function mount(): void
    {
        $this->section->load(['news.teacher.user']);
    }

    public function render()
    {
        return view('livewire.teacher.manage-sections.news-tab');
    }
}
