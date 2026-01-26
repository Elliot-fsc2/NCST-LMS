<?php

use App\Models\Section;
use Livewire\Attributes\Url;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

new class extends Component implements HasActions, HasSchemas {
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Section $section;

    #[Url]
    public string $tab = 'news';

    public function mount(): void
    {
        $this->section->load(['students.user', 'lessons', 'quizzes', 'news.teacher', 'course']);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label('Delete Section')
            ->requiresConfirmation()
            ->modalHeading('Delete Section')
            ->modalSubheading('Are you sure you want to delete this section? This will also delete all lessons, quizzes, and news associated with this section.')
            ->modalButton('Delete')
            ->color('danger')
            ->action(function () {
                try {
                    DB::transaction(function () {
                        $this->section->lessons()->delete();
                        $this->section->quizzes()->delete();
                        $this->section->news()->delete();
                        $this->section->students()->detach();

                        $this->section->delete();
                    });

                    Notification::make()->title('Section deleted successfully.')->success()->send();

                    $this->redirectRoute('teacher.manage-sections', navigate: true);
                } catch (\Exception $e) {
                    Notification::make()->title('Error deleting section')->body('Unable to delete this section. Please try again.')->danger()->send();
                }
            });
    }
};
?>

<x-slot name="title">{{ $section->name }}</x-slot>
<x-slot name="header">{{ $section->name }}</x-slot>

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Actions -->
        <div class="flex items-center justify-between mb-6">
            <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('teacher.manage-sections') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                    Sections
                </a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ $section->name }}</span>
            </nav>

            <div>
                {{ $this->deleteAction }}
            </div>
        </div>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tabs Navigation -->
                <div class="-mx-4 sm:mx-0">
                    <div class="border-b border-gray-200 dark:border-gray-800">
                        <nav class="flex gap-1 md:gap-2 overflow-x-auto hide-scrollbar px-4 sm:px-0" aria-label="Tabs">
                            <button type="button" wire:click="setTab('news')"
                                class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $tab === 'news' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                                <div class="flex items-center gap-1.5 md:gap-2">
                                    <x-heroicon-o-newspaper class="w-4 h-4 md:w-5 md:h-5" />
                                    <span>News</span>
                                </div>
                            </button>

                            <button type="button" wire:click="setTab('lessons')"
                                class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $tab === 'lessons' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                                <div class="flex items-center gap-1.5 md:gap-2">
                                    <x-heroicon-o-book-open class="w-4 h-4 md:w-5 md:h-5" />
                                    <span>Lessons</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div>
                    @if ($tab === 'news')
                        <livewire:teacher.manage-sections.news-tab :section="$section" />
                    @elseif ($tab === 'lessons')
                        <livewire:teacher.manage-sections.lessons-tab :section="$section" />
                    @endif
                </div>
            </div>

            <!-- Aside/Sidebar (Right) -->
            <aside class="lg:col-span-1 space-y-4">
                <!-- Statistics -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Statistics</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Lessons</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->lessons->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Students</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->students->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Quizzes</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ $section->quizzes->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Students -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Students</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2 max-h-80 overflow-y-auto">
                        @forelse ($section->students->take(10) as $student)
                            <div class="flex items-center gap-2 py-1.5">
                                <div
                                    class="w-7 h-7 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-xs font-medium text-gray-700 dark:text-gray-300">
                                    {{ substr($student->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700 dark:text-gray-300 flex-1 truncate">
                                    {{ $student->user->name }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 py-2">None</p>
                        @endforelse
                    </div>
                </div>

                <!-- Announcements -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Announcements</h3>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        @forelse ($section->news->take(3) as $newsItem)
                            <div class="py-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $newsItem->title }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">None</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <x-filament-actions::modals />
</div>
