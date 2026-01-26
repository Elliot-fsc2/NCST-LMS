<?php

use Livewire\Component;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use App\Models\Course;
use App\Models\Teacher;
use Filament\Notifications\Notification;

new class extends Component implements HasSchemas {
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Section Details')->schema([
                    TextInput::make('name')->label('Section Name')->required()->placeholder('Enter section name'),
                    Select::make('course_id')
                        ->label('Course')
                        ->required()
                        ->options(function () {
                            return Course::where('department_id', auth()->user()->profile->department_id)
                                ->pluck('code', 'id')
                                ->toArray();
                        }),
                    Select::make('teacher_id')
                        ->options(function () {
                            return Teacher::with('user')->get()->pluck('user.name', 'id');
                        })
                        ->label('Teacher')
                        ->searchable()
                        ->noSearchResultsMessage('No teachers found.')
                        ->required(),
                ]),
            ])
            ->statePath('data');
    }

    public function createSection(): void
    {
        $data = $this->form->getState();

        App\Models\Section::create([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'teacher_id' => $data['teacher_id'],
        ]);

        $this->form->fill();

        Notification::make()->title('Section Created')->body('The section has been created successfully.')->success()->send();
    }
};
?>

<x-slot name="title">Create Sections</x-slot>
<x-slot name="header">Create Section</x-slot>
<x-slot name="subheader">Create a new class section and assign it to a course.
</x-slot>

<div>
    <div class="p-6">
        <form wire:submit="createSection">
            {{ $this->form }}
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create
                Section</button>
        </form>
    </div>
</div>
