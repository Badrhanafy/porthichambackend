<?php
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Api\ProjectController;

Route::apiResource('projects', ProjectController::class);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);