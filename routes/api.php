<?php
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\AuthController;

Route::apiResource('projects', ProjectController::class);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);