<?php

use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('My Sections')]
class extends Component
{
    // public function mount()
    // {
    //     Auth::loginUsingId(2);
    // }
    public function with(): array
    {
        $teacher = Auth::user()->profile;

        $sections = Section::query()
            ->where('teacher_id', $teacher->id)
            ->with(['course', 'students'])
            ->withCount('students')
            ->get();

        return [
            'sections' => $sections,
        ];
    }
};
