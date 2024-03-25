<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::resource('note', NoteController::class);