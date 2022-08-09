<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use LaraStrict\Health\Http\Controllers\AliveController;

Route::get('/alive', AliveController::class)
    ->withoutMiddleware('api');
