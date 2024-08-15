<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// 個別表示
Route::get('/books/{isbn}', [BookController::class, 'index'])->name('book.index');


// 登録
Route::get('/save', function() {
    return Inertia::render('Book/Save');
})->name('book.edit');

Route::post('/save', [BookController::class, 'save'])
->name('book.save');


// テスト
Route::get('/test_gl', function() {
    return Inertia::render('Test_gl');
})->name('test_gl');

Route::get('/test_python', [BookController::class, 'test_python'])
->name('test_python');


require __DIR__.'/auth.php';
