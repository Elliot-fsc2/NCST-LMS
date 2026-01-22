<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Students',
                Student::count()
            )
                ->description('As of Today')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make(
                'Total Teachers',
                Teacher::count()
            )
                ->description('As of Today')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Total Courses', 0)
                ->description('As of Today')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('warning'),
        ];
    }
}
