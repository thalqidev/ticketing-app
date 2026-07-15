<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Inline middleware for administrative access control
class GembokAdminMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda bukan admin!');
    }
}

// Public & Authenticated User Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/orders', [OrderController::class, 'index'])->middleware(['auth'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->middleware(['auth'])->name('orders.store');

// Protected Admin Routes
Route::middleware(['auth', 'verified', GembokAdminMiddleware::class])->prefix('admin')->group(function () {

    // Category Management
    Route::name('categories.')->group(function () {
        Route::get('/categories', [DashboardController::class, 'index'])->name('index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Event Management
    Route::name('events.')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('index');
        Route::get('/events/create', [EventController::class, 'create'])->name('create');
        Route::post('/events', [EventController::class, 'store'])->name('store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('destroy');
    });
    Route::name('transactions.')->group(function () {
        Route::get('/transactions', [OrderController::class, 'adminIndex'])->name('index');
    });
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';