<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepositoriesController;

use function Pest\Laravel\post;


Route::get('/', [RepositoriesController::class, 'index']);
Route::get('/repositories/create', [RepositoriesController::class, 'create']);
Route::get('/repositories/index/{repositories}', [RepositoriesController::class, 'show']);
Route::post('/repositories', [RepositoriesController::class, 'store']);
Route::post('/repositories/view', [FilesController::class, 'store']);
Route::get('/files/index/{file}', [FilesController::class, 'index']);
Route::get('/files/view/{id}/{file}', [FilesController::class, 'show']);
Route::get('/files/view/{file}', [FilesController::class, 'show']);

