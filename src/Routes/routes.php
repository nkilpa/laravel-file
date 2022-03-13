<?php

use Illuminate\Support\Facades\Route;
use nikitakilpa\File\Controllers\FileController;

Route::prefix('file')->group(function () {
    Route::get('/hello', [FileController::class, 'hello']);

    Route::post('/add-job', [FileController::class, 'addJob']);

    Route::post('/add-jobs', [FileController::class, 'addJobs']);
});
