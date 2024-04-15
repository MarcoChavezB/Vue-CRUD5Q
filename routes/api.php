<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// grupo de rutas con prefijo 
Route::prefix('user')->group(function () {
    Route::post('/store', [UserController::class, 'store']);    
    Route::post('/login', [UserController::class, 'login'])->middleware('guest:sanctum');    
});


Route::get('/getToken', [UserController::class, 'create_token']);