<?php

namespace App\Livewire\Teacher;

use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Sections')]
class Sections extends Component
{
    public function render(): View
    {
        $teacher = Auth::user()->profile;

        $sections = Section::query()
            ->where('teacher_id', $teacher->id)
            ->with(['course', 'students'])
            ->withCount('students')
            ->get();

        return view('livewire.teacher.sections', [
            'sections' => $sections,
        ]);
    }
}
