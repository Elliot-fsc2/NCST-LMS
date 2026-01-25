<?php

namespace App\Filament\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use app\Models\User;
use Filament\Tables\Columns\TextColumn;

class UserTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => User::query())
            ->columns([
                TextColumn::make('name')->label('Name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
