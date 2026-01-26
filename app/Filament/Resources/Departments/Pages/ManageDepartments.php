<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions\Action;

class ManageDepartments extends ManageRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('manageDepartmentHead')
                ->label('Manage Department Heads')
                ->color('success')
                ->url(fn(): string => DepartmentHeads::getUrl()),
        ];
    }
}
