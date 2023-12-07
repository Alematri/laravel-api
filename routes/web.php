<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\projectController;
use App\Http\Controllers\Admin\typeController;
use App\Http\Controllers\Admin\technologyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// rotte pubbliche
Route::get('/',[PageController::class, 'index'])->name('home');

// rotte auth di gestione del profilo
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// rotte privata
Route::middleware(['auth', 'verified'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('home');
            Route::resource('projects', projectController::class);
            Route::resource('technologies', technologyController::class);
            Route::resource('types', typeController::class);
            // rotta custom
            Route::get('technology-project', [technologyController::class, 'technologyproject'])->name('technology-project');
            Route::get('project-type/{type}', [typeController::class, 'projectstypes'])->name('project-type');
            Route::get('order-by/{direction}/{column}', [projectController::class, 'orderBy'])->name('order-by');
            Route::get('search', [projectController::class, 'search'])->name('search');
            Route::get('no-types', [projectController::class, 'notypes'])->name('no-types');

        });


// rotte auth di gestione dell'account
require __DIR__.'/auth.php';
