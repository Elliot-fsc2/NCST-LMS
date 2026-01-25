<?php

use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Teacher\Sections;
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
});
