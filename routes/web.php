<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'pages.landing')
    ->name('landing');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Volt::route('decks', 'pages.decks')
    ->middleware(['auth', 'verified'])
    ->name('decks');

Volt::route('decks/{id}', 'pages.decks.edit')
    ->middleware(['auth', 'verified'])
    ->name('decks.edit');

Volt::route('dex', 'pages.dex')
    ->middleware(['auth', 'verified'])
    ->name('dex');

Volt::route('search', 'pages.search')
    ->middleware(['auth', 'verified'])
    ->name('search');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
