<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateForm(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->getComponent('email')
            ->unique('users', 'email');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove email and password from student data
        unset($data['email'], $data['password']);

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $email = $this->data['email'];
        $password = $this->data['password'];

        $student = static::getModel()::create($data);

        $student->user()->create([
            'name' => trim("{$student->first_name} {$student->middle_name} {$student->last_name}"),
            'email' => $email,
            'password' => $password,
            'role' => 'student',
        ]);

        return $student;
    }
}
