<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('teacher.sections') }}"
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <x-heroicon-o-arrow-left class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $section->name }}</h2>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $section->course->name ?? 'No Course' }}
                    @if ($section->course?->code)
                        <span class="text-gray-400">•</span>
                        <span class="text-[#204ab5] dark:text-blue-400 font-medium">{{ $section->course->code }}</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-800">
            <nav class="flex gap-2" aria-label="Tabs">
                <button wire:click="setActiveTab('lessons')"
                    class="px-6 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'lessons' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-book-open class="w-5 h-5" />
                        <span>Lessons</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('news')"
                    class="px-6 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'news' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-newspaper class="w-5 h-5" />
                        <span>News</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('students')"
                    class="px-6 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'students' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-user-group class="w-5 h-5" />
                        <span>Students</span>
                    </div>
                </button>

                <button wire:click="setActiveTab('teachers')"
                    class="px-6 py-3 text-sm font-medium transition-colors border-b-2 {{ $activeTab === 'teachers' ? 'border-[#204ab5] text-[#204ab5] dark:text-blue-400 dark:border-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-academic-cap class="w-5 h-5" />
                        <span>Teachers</span>
                    </div>
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div>
        @if ($activeTab === 'lessons')
            <livewire:teacher.section-show.lessons :section="$section" :key="'lessons-' . $section->id" />
        @elseif ($activeTab === 'news')
            <livewire:teacher.section-show.news :section="$section" :key="'news-' . $section->id" />
        @elseif ($activeTab === 'students')
            <livewire:teacher.section-show.students :section="$section" :key="'students-' . $section->id" />
        @elseif ($activeTab === 'teachers')
            <livewire:teacher.section-show.teachers :section="$section" :key="'teachers-' . $section->id" />
        @endif
    </div>
</div>
