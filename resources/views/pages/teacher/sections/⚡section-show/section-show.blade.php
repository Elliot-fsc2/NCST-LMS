<x-slot name="title">{{ $section->name }} - {{ config('app.name') }}</x-slot>
<x-slot name="header">{{ $section->name }}</x-slot>
<x-slot name="subheader">{{ $section->course->name ?? 'No Course' }}</x-slot>

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Tabs Navigation -->
        <div class="mb-4 md:mb-6 -mx-4 sm:mx-0">
            <div class="border-b border-gray-200 dark:border-gray-800">
                <nav class="flex gap-1 md:gap-2 overflow-x-auto hide-scrollbar px-4 sm:px-0" aria-label="Tabs">
                    <button type="button" wire:click="setTab('lessons')"
                        class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'lessons' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                        <div class="flex items-center gap-1.5 md:gap-2">
                            <x-heroicon-o-book-open class="w-4 h-4 md:w-5 md:h-5" />
                            <span>Lessons</span>
                        </div>
                    </button>

                    <button type="button" wire:click="setTab('news')"
                        class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'news' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                        <div class="flex items-center gap-1.5 md:gap-2">
                            <x-heroicon-o-newspaper class="w-4 h-4 md:w-5 md:h-5" />
                            <span>News</span>
                        </div>
                    </button>

                    <button type="button" wire:click="setTab('students')"
                        class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'students' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                        <div class="flex items-center gap-1.5 md:gap-2">
                            <x-heroicon-o-user-group class="w-4 h-4 md:w-5 md:h-5" />
                            <span>Students</span>
                        </div>
                    </button>

                    <button type="button" wire:click="setTab('teachers')"
                        class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'teachers' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                        <div class="flex items-center gap-1.5 md:gap-2">
                            <x-heroicon-o-academic-cap class="w-4 h-4 md:w-5 md:h-5" />
                            <span>Teachers</span>
                        </div>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div>
            @if ($activeTab === 'lessons')
                <livewire:teacher.section.lessons-tab :section="$section" />
            @elseif ($activeTab === 'news')
                <livewire:teacher.section.news-tab :section="$section" />
            @elseif ($activeTab === 'students')
                <livewire:teacher.section.students-tab :section="$section" />
            @elseif ($activeTab === 'teachers')
                <livewire:teacher.section.teachers-tab :section="$section" />
            @endif
        </div>
    </div>
</div>
