<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QueueController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/slow-projects', [ProjectController::class, 'slow']);
Route::get('/fast-projects', [ProjectController::class, 'fast']);

Route::get('/without-queue', [QueueController::class, 'withoutQueue']);
Route::get('/with-queue', [QueueController::class, 'withQueue']);
