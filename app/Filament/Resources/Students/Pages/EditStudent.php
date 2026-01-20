<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateForm(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->getComponent('email')
            ->unique('users', 'email', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                return $rule->where('userable_id', $this->record->id)
                    ->where('userable_type', $this->record::class);
            });
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load email from the related user
        $data['email'] = $this->record->user?->email;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove email and password from student data
        unset($data['email'], $data['password']);

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $email = $this->data['email'] ?? null;
        $password = $this->data['password'] ?? null;

        // Update the student
        $record->update($data);

        // Update the user
        $userData = [];
        if ($email) {
            $userData['email'] = $email;
            $userData['name'] = trim("{$record->first_name} {$record->middle_name} {$record->last_name}");
        }
        if ($password) {
            $userData['password'] = Hash::make($password);
        }

        if (!empty($userData)) {
            $record->user()->update($userData);
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
