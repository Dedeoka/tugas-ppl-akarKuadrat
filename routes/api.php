<?php

use Illuminate\Support\Facades\Route;

//posts
Route::apiResource('/test', App\Http\Controllers\Api\TestController::class);
