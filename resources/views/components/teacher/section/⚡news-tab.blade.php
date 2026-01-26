<?php

use App\Models\Section;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

new class extends Component implements HasActions, HasForms {
    use InteractsWithActions;
    use InteractsWithForms;

    public Section $section;

    public function news()
    {
        return $this->section->news()->latest()->get();
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Create Announcement')
            ->icon('heroicon-o-plus')
            ->color('primary')
            ->modalHeading('Create Announcement')
            ->modalSubmitActionLabel('Create')
            ->modalWidth('2xl')
            ->schema([TextInput::make('title')->required()->maxLength(255)->autofocus()->placeholder('Enter announcement title'), Textarea::make('content')->required()->rows(6)->placeholder('Write your announcement here...')->columnSpanFull()])
            ->action(function (array $data): void {
                $this->section->news()->create([
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'teacher_id' => $this->section->teacher_id,
                ]);
            });
    }
};
?>


<div>
    @if ($this->news()->isEmpty())
        <!-- Empty State -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-8 md:p-12 text-center">
            <div
                class="mx-auto w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <x-heroicon-o-newspaper class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
            </div>
            <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">No announcements yet</h3>
            <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                News and announcements for this section will appear here.
            </p>
            <div class="mt-6">
                {{ $this->createAction }}
            </div>
        </div>
    @else
        <!-- Create Announcement Button -->
        <div class="mb-4">
            {{ ($this->createAction)(['color' => 'primary']) }}
        </div>

        <!-- Announcements List -->
        <div class="space-y-3 md:space-y-4">
            @foreach ($this->news() as $announcement)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 shrink-0">
                            <x-heroicon-o-megaphone class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $announcement->title }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                {{ $announcement->content }}
                            </p>
                            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                Posted {{ $announcement->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <x-filament-actions::modals />
</div>
