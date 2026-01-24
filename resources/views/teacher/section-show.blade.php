<x-auth-layout>
    <x-slot name="title">{{ $section->name }} - {{ config('app.name') }}</x-slot>

    <div class="py-6 md:py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6 md:mb-8">
                <div class="flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 md:gap-3 mb-2">
                            <a href="{{ route('teacher.sections') }}"
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors shrink-0">
                                <x-heroicon-o-arrow-left class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                            </a>
                            <h2
                                class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white whitespace-normal md:truncate">
                                {{ $section->name }}</h2>
                        </div>
                        <p
                            class="text-xs md:text-sm text-gray-600 dark:text-gray-400 px-10 md:px-11 whitespace-normal md:truncate">
                            {{ $section->course->name ?? 'No Course' }}
                            @if ($section->course?->code)
                                <span class="text-gray-400">•</span>
                                <span
                                    class="text-[#204ab5] dark:text-blue-400 font-medium">{{ $section->course->code }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-4 md:mb-6 -mx-4 sm:mx-0">
                <div class="border-b border-gray-200 dark:border-gray-800">
                    <nav class="flex gap-1 md:gap-2 overflow-x-auto hide-scrollbar px-4 sm:px-0" aria-label="Tabs">
                        <a wire:navigate
                            href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'lessons']) }}"
                            class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'lessons' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <div class="flex items-center gap-1.5 md:gap-2">
                                <x-heroicon-o-book-open class="w-4 h-4 md:w-5 md:h-5" />
                                <span>Lessons</span>
                            </div>
                        </a>

                        <a wire:navigate
                            href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'news']) }}"
                            class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'news' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <div class="flex items-center gap-1.5 md:gap-2">
                                <x-heroicon-o-newspaper class="w-4 h-4 md:w-5 md:h-5" />
                                <span>News</span>
                            </div>
                        </a>

                        <a wire:navigate
                            href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'students']) }}"
                            class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'students' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <div class="flex items-center gap-1.5 md:gap-2">
                                <x-heroicon-o-user-group class="w-4 h-4 md:w-5 md:h-5" />
                                <span>Students</span>
                            </div>
                        </a>

                        <a wire:navigate
                            href="{{ route('teacher.sections.show', ['section' => $section, 'tab' => 'teachers']) }}"
                            class="px-4 md:px-6 py-2.5 md:py-3 text-xs md:text-sm font-medium transition-colors border-b-2 whitespace-nowrap {{ $activeTab === 'teachers' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <div class="flex items-center gap-1.5 md:gap-2">
                                <x-heroicon-o-academic-cap class="w-4 h-4 md:w-5 md:h-5" />
                                <span>Teachers</span>
                            </div>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div>
                @if ($activeTab === 'lessons')
                    @include('teacher.section-show.lessons')
                @elseif ($activeTab === 'news')
                    @include('teacher.section-show.news')
                @elseif ($activeTab === 'students')
                    @include('teacher.section-show.students')
                @elseif ($activeTab === 'teachers')
                    @include('teacher.section-show.teachers')
                @endif
            </div>
        </div>
    </div>
</x-auth-layout>
