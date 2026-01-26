<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return match (Auth::user()?->role) {
        'admin' => redirect('admin'),
        'teacher' => redirect()->route('teacher.home'),
        'student' => redirect()->route('student.home'),
        default => redirect()->route('login'),
    };
});

Route::fallback(function () {
    return match (Auth::user()?->role) {
        'admin' => redirect('admin'),
        'teacher' => redirect()->route('teacher.home'),
        'student' => redirect()->route('student.home'),
        default => redirect()->route('login'),
    };
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

// Student Routes
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/home', function () {
        return view('student.home');
    })->name('student.home');
});

// Teacher Routes
Route::middleware(['auth', 'teacher'])->prefix('teacher')->group(function () {
    Route::get('/', function () {
        return view('teacher.home');
    })->name('teacher.home');

    Route::livewire('/sections', 'pages::teacher.sections')->name('teacher.sections');

    Route::livewire('/sections/{section}', 'pages::teacher.sections.section-show')
        ->middleware('can:view,section')
        ->name('teacher.sections.show');

    Route::livewire('/sections/{section}/lessons/create', 'pages::teacher.lesson-tab.create')
        ->name('teacher.lesson.create');

    Route::livewire('/sections/{section}/lessons/{lesson:id}', 'pages::teacher.lesson-tab.view')
        ->middleware('can:view,lesson')
        ->scopeBindings()
        ->name('teacher.lesson.view');

    Route::livewire('/sections/{section}/lessons/{lesson:id}/edit', 'pages::teacher.lesson-tab.edit')
        ->middleware('can:update,lesson')
        ->scopeBindings()
        ->name('teacher.lesson.edit');

    Route::livewire('/manage-sections', 'pages::teacher.manage-sections')
        ->middleware('can:create,App\Models\Section')
        ->name('teacher.manage-sections');

    Route::livewire('/manage-sections/create', 'pages::teacher.manage-sections.create')
        ->middleware('can:create,App\Models\Section')
        ->name('teacher.manage-sections.create');

    Route::livewire('/manage-sections/{section}', 'pages::teacher.manage-sections.view')
        ->middleware('can:view,App\Models\Section')
        ->name('teacher.manage-sections.view');
});
