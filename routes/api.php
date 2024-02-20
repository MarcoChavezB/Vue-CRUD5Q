<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\UniversidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});






    Route::get('/getUniversidades', [UniversidadController::class, 'index'])
        ->name('Universidad.index');

    Route::get('/getUniversidad/{id}', [UniversidadController::class, 'getUniversidad'])
        ->where('id', '[0-9]+')
        ->name('Universidad.getUniversidad');

    Route::put('/updateUniversidad', [UniversidadController::class, 'updateUniversidad'])
        ->name('Universidad.updateUniversidad');

    Route::post('/createUniversidad', [UniversidadController::class, 'createUniversidad'])
        ->name('Universidad.createUniversidad');

    Route::delete('/deleteUniversidad/{id}', [UniversidadController::class, 'deleteUniversidad'])
        ->where('id', '[0-9]+')
        ->name('Universidad.deleteUniversidad');




    Route::get('/getCarreras/{id}', [CarreraController::class, 'getCarrera'])
        ->where('id', '[0-9]+')
        ->name('Carrera.getCarreras');

    Route::get('/getCarrera/{id}', [CarreraController::class, 'getCarreras'])
        ->where('id', '[0-9]+')
        ->name('Carrera.getCarrera');

    Route::put('/updateCarrera', [CarreraController::class, 'updateCarrera'])
        ->name('Carrera.updateCarrera');

    Route::post('/createCarrera', [CarreraController::class, 'createCarrera'])
        ->name('Carrera.createCarrera');

    Route::delete('/deleteCarrera/{id}', [CarreraController::class, 'deleteCarrera'])
        ->where('id', '[0-9]+')
        ->name('Carrera.deleteCarrera');




    Route::get('/getMaterias/{id}', [MateriaController::class, 'getMaterias'])
        ->where('id', '[0-9]+')
        ->name('Materia.getMaterias');

    Route::get('/getMateria/{id}', [MateriaController::class, 'getMateria'])
        ->where('id', '[0-9]+')
        ->name('Materia.getMateria');

    Route::put('/updateMateria', [MateriaController::class, 'updateMateria'])
        ->name('Materia.updateMateria');

    Route::post('/createMateria', [MateriaController::class, 'createMateria'])
        ->name('Materia.createMateria');

    Route::delete('/deleteMateria/{id}', [MateriaController::class, 'deleteMateria'])
        ->where('id', '[0-9]+')
        ->name('Materia.deleteMateria');




    Route::get('/getProfesores/{id}', [ProfesorController::class, 'getProfesores'])
        ->where('id', '[0-9]+')
        ->name('Profesor.getProfesores');

    Route::get('/getProfesor/{id}', [ProfesorController::class, 'getProfesor'])
        ->where('id', '[0-9]+')
        ->name('Profesor.getProfesor');

    Route::put('/updateProfesor', [ProfesorController::class, 'updateProfesor'])
        ->name('Profesor.updateProfesor');

    Route::post('/createProfesor', [ProfesorController::class, 'createProfesor'])
        ->name('Profesor.createProfesor');

    Route::delete('/deleteProfesor/{id}', [ProfesorController::class, 'deleteProfesor'])
        ->where('id', '[0-9]+')
        ->name('Profesor.deleteProfesor');

    Route::post('/agregarMateria', [ProfesorController::class, 'agregarMateria'])
        ->where('id', '[0-9]+')
        ->name('Profesor.agregarMateria');
        


    Route::get('/getAlumnos/{id}', [AlumnoController::class, 'getAlumnos'])
        ->where('id', '[0-9]+')    
        ->name('Alumno.getAlumnos');

    Route::get('/getAlumno/{id}', [AlumnoController::class, 'getAlumno'])
        ->where('id', '[0-9]+')    
        ->name('Alumno.getAlumno');

    Route::put('/updateAlumno', [AlumnoController::class, 'updateAlumno'])
        ->name('Alumno.updateAlumno');

    Route::post('/createAlumno', [AlumnoController::class, 'createAlumno'])
        ->name('Alumno.createAlumno');

    Route::delete('/deleteAlumno/{id}', [AlumnoController::class, 'deleteAlumno'])
        ->where('id', '[0-9]+')    
        ->name('Alumno.deleteAlumno');

    Route::post('/agregarProfesor', [AlumnoController::class, 'agregarProfesor'])
        ->where('id', '[0-9]+')
        ->name('Alumno.agregarProfesor');
