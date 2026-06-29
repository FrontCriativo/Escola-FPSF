<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TCCController;

Route::get('/', [TCCController::class, 'index'])->name('tcc.index');
Route::get('/tcc', [TCCController::class, 'index']);
