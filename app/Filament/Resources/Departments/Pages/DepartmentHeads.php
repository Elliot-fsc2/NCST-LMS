<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use App\Models\Department;
use App\Models\Teacher;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

/**
 * @property-read Schema $form
 */
class DepartmentHeads extends Page
{
    protected static string $resource = DepartmentResource::class;

    protected string $view = 'filament.resources.departments.pages.department-heads';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'departments' => Department::with('teachers')
                ->get()
                ->map(function (Department $department) {
                    $head = $department->teachers()->where('is_department_head', true)->first();
                    return [
                        'department_id' => $department->id,
                        'department_name' => $department->name,
                        'teacher_id' => $head?->id,
                    ];
                })
                ->toArray(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Repeater::make('departments')
                        ->schema([
                            TextInput::make('department_name')
                                ->label('Department')
                                ->disabled()
                                ->dehydrated(false),
                            Select::make('teacher_id')
                                ->label('Department Head')
                                ->options(function (callable $get) {
                                    $departmentId = $get('department_id');
                                    if (!$departmentId) {
                                        return [];
                                    }
                                    return Teacher::where('department_id', $departmentId)
                                        ->get()
                                        ->mapWithKeys(function (Teacher $teacher) {
                                            $fullName = trim("{$teacher->first_name} {$teacher->middle_name} {$teacher->last_name}");
                                            return [$teacher->id => $fullName];
                                        });
                                })
                                ->searchable()
                                ->nullable()
                                ->placeholder('Select a department head')
                                ->helperText('Leave empty to remove current department head'),
                            TextInput::make('department_id')
                                ->hidden()
                                ->dehydrated(true),
                        ])
                        ->columns(2)
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->itemLabel(fn(array $state): ?string => $state['department_name'] ?? null)
                        ->defaultItems(0),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save Changes')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $departments = Department::all();
        $departmentIds = [];
        $newHeadIds = [];

        // Collect department IDs and new head IDs
        foreach ($data['departments'] as $index => $departmentData) {
            $department = $departments[$index] ?? null;

            if (!$department) {
                continue;
            }

            $departmentIds[] = $department->id;

            if (!empty($departmentData['teacher_id'])) {
                $newHeadIds[] = $departmentData['teacher_id'];
            }
        }

        // Remove all current department heads in a single query
        Teacher::whereIn('department_id', $departmentIds)
            ->where('is_department_head', true)
            ->update(['is_department_head' => false]);

        // Set new department heads in a single query
        if (!empty($newHeadIds)) {
            Teacher::whereIn('id', $newHeadIds)
                ->update(['is_department_head' => true]);
        }

        $this->mount();

        Notification::make()
            ->success()
            ->title('Department heads updated')
            ->body('The department heads have been successfully updated.')
            ->send();
    }
}
