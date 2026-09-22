<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/catalog', 'catalog')->name('catalog');
Route::view('/shop/{category}', 'shop')
    ->whereIn('category', ['all', 'hives', 'bodies', 'bottoms', 'roofs', 'frames', 'tools'])
    ->name('shop.category');
Route::view('/tips', 'tips')->name('tips');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
