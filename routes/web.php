<?php

use App\Http\Controllers\CommitsController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CollaboratorsController;

Route::get('/', [RepositoriesController::class, 'index']);
Route::get('/repositories/create', [RepositoriesController::class, 'create']);
Route::post('/repositories/view', [FilesController::class, 'store']);
Route::get('/repositories/delete/{id}', [RepositoriesController::class, 'delete']);
Route::get('/repositories/index/{repositories}', [RepositoriesController::class, 'show']);
Route::post('/repositories', [RepositoriesController::class, 'store']);
Route::get('/check-repo-name', [RepositoriesController::class, 'checkRepoName'])->name('checkRepoName');
Route::get('/search-repositories', [RepositoriesController::class, 'search']);
Route::get('/files/index/{file}', [FilesController::class, 'index']);
Route::get('/files/view/{file}', [FilesController::class, 'show']);
Route::get('/files/update/{file}', [FilesController::class, 'update']);
Route::get('/files/view/{id}/{file}', [FilesController::class, 'show']);
Route::get('/commits/index/{id}', [CommitsController::class, 'index']);
Route::get('/commits/view/{id}/{commit}', [CommitsController::class, 'store']);
Route::get('/commits/view/{id}/{commit}/{files}', [CommitsController::class, 'store']);
Route::get('/commits/delete/{id}/{commit}', [CommitsController::class, 'delete']);
Route::get('/collaborators/index/{id}', [CollaboratorsController::class, 'index']);
Route::get('/collaborators/index/{id}/{user}', [CollaboratorsController::class, 'create']);
Route::get('/collaborators/delete/{id}/{user}', [CollaboratorsController::class, 'delete']);
Route::get('/search-collaborators', [CollaboratorsController::class, 'search']);
Route::get('/search-users', [CollaboratorsController::class, 'search']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
