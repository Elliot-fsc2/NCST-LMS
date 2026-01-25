<?php

use App\Models\Section;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

new class extends Component
{
    public Section $section;

    #[On('section.lessons.updated')]
    #[Computed]
    public function lessons()
    {
        return $this->section->lessons()->latest()->get();
    }
};
