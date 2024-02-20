<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversidadController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [UserController::class, 'index'])
//     ->name('User.index');



Route::middleware('auth')->group(function () {
    Route::inertia('/returnTable', 'IndexTable')
        ->name('Universidad.returnTable')
        ->middleware(['auth', 'verified']);;

    Route::inertia('/returnAddForm', 'AddForm')
        ->name('Universidad.returnAddForm');

    Route::post('/renderModal', function (){
        return Inertia::render('Modals/modal');
    })->name('Modal.renderModal');

    Route::post('/form/update/{nivel}', [FormController::class, 'update'])
        ->name('Form.update')
        ->where('id', '[0-9]+');
});




Route::get('/returnForm', [FormController::class, 'returnForm'])
    ->name('Form.returnForm')
    ->middleware(['auth', 'verified']);


Route::get('/', [FormController::class, 'returnIndex'])
    ->name('Form.returnIndex');

    
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    require __DIR__.'/auth.php';