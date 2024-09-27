<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [ APIController::class, 'index' ]);
Route::get('/developers', [ APIController::class, 'developers' ]);
Route::get('/task-assignments', [ APIController::class, 'assignments' ]);
