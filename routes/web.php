<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;

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

Route::get('/movie/{movie}', function ($movieId) {
    return Inertia::render('Movies/Movie', [
        'movieId' => $movieId,
    ]);;
})->middleware(['auth','verified'])->name('movie');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get("/movies/search", [MovieController::class, "search"])->name("movies.search");
    Route::get("/movies/{id}", [MovieController::class, "getMovieById"])->name("movies.getById");
    Route::post("/movies", [MovieController::class, "save"])->name("movies.save");
    Route::get("/movies/imagePath", [MovieController::class, "getImagePath"])->name("movies.imagePath");
});

require __DIR__.'/auth.php';
