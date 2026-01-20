<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function mutateForm(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->getComponent('email')
            ->unique('users', 'email');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove email and password from teacher data
        unset($data['email'], $data['password']);

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $email = $this->data['email'];
        $password = $this->data['password'];

        $teacher = static::getModel()::create($data);


        $teacher->user()->create([
            'name' => trim("{$teacher->first_name} {$teacher->middle_name} {$teacher->last_name}"),
            'email' => $email,
            'password' => $password,
            'role' => 'teacher',
        ]);

        return $teacher;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
