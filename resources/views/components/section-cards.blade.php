@props([
    'sectionName',
    'students' => 0,
    'course' => 'Bachelor of Science in Information Technology',
    'teacher' => 'Teacher Name',
    'image' => asset('images/classroom.png'),
])
<div>

    <article
        class="flex flex-col bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 dark:from-blue-600 dark:via-blue-700 dark:to-indigo-700 h-80 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
        <div class="relative h-48 md:h-56 overflow-hidden bg-stone-200 dark:bg-stone-800">
            <img src="{{ $image }}"
                class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                alt="{{ $course }} image" />

            <div
                class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent pointer-events-none">
            </div>

            <span
                class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full bg-white/90 text-xs font-semibold px-3 py-1 shadow-sm dark:bg-black/60 dark:text-stone-100">
                {{ $course }}
            </span>
        </div>

        <div class="p-4 flex flex-col gap-3 bg-white dark:bg-gray-900 flex-1">
            <div class="flex items-start justify-between gap-4">
                <h3 class="text-lg lg:text-xl font-bold text-stone-900 dark:text-stone-50 truncate"
                    aria-describedby="featureDescription">{{ $sectionName }}</h3>

                <div class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center rounded-md bg-blue-100 dark:bg-blue-900 px-2.5 py-1 text-xs font-medium text-blue-700 dark:text-blue-200">
                        {{ number_format($students) }} {{ Str::plural('student', $students) }}
                    </span>
                </div>
            </div>

            <p id="featureDescription" class="text-sm text-stone-600 dark:text-stone-300">
                Instructor: <span class="font-medium text-stone-800 dark:text-stone-100">{{ $teacher }}</span>
            </p>
        </div>
    </article>
</div>
