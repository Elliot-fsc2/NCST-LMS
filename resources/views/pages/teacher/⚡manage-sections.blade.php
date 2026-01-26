<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Section;
use App\Models\Course;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;

new class extends Component implements HasSchemas {
    use InteractsWithSchemas;

    public ?int $selectedCourse = null;

    public function sections()
    {
        return Section::query()
            ->whereRelation('course', 'department_id', auth()->user()->profile->department_id)
            ->with(['course', 'teacher.user'])
            ->when($this->selectedCourse, fn($query) => $query->where('course_id', $this->selectedCourse))
            ->withCount('students')
            ->get();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('selectedCourse')
                ->label('Filter by Course')
                ->inlineLabel()
                ->options(function () {
                    return Course::where('department_id', auth()->user()->profile->department_id)
                        ->pluck('code', 'id')
                        ->toArray();
                })
                ->live(),
        ]);
    }
};
?>

<x-slot name="title">Manage Sections</x-slot>
<x-slot name="header">Manage Sections</x-slot>
<x-slot name="subheader">Manage your class sections and view enrolled students.
</x-slot>

<div>
    <div class="p-6 pb-0 mb-5">
        <div class="inline-flex items-center gap-4 w-auto">
            {{ $this->form }}
        </div>
    </div>
    <div class="p-6 pt-0">
        <a href="{{ route('teacher.manage-sections.create') }}" wire:navigate
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-label="Create Section">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Section
        </a>
    </div>

    <hr>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-7 p-6" wire:key="sections-{{ $selectedCourse }}">
        @forelse ($this->sections() as $section)
            <a href="{{ route('teacher.manage-sections.view', ['section' => $section]) }}"
                class="block"
                wire:key="section-link-{{ $section->id }}">
                <x-section-cards :sectionName="$section->name" :students="$section->students_count" :course="$section->course->code" :teacher="$section->teacher->user->name"
                    wire:key="section-{{ $section->id }}" />
            </a>
        @empty
            <p>No sections found.</p>
        @endforelse
    </div>
</div>
