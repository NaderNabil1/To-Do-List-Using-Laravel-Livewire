<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AddTodos;

Route::view('/', 'home')->middleware(['auth', 'verified'])->name('home');
Route::get('/add-todo', AddTodos::class)->middleware(['auth'])->name('add-todo');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';
