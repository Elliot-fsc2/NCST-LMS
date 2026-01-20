<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::get('registers', App\Http\Controllers\Auth\RegisterController::class);
