<?php

use App\Http\Controllers\Blog\IndexController;
use App\Http\Controllers\Blog\ShowController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
})->name('landing');

Route::get('/blog', IndexController::class)->name('blog.index');
Route::get('/blog/{slug}', ShowController::class)->name('blog.show');

if (! app()->environment('production')) {
    Route::get('/lorekeeper', function () {
        return Inertia::render('Lorekeeper');
    })->name('lorekeeper');

    Route::get('/resume', function () {
        return Inertia::render('Resume');
    })->name('resume');
}

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
