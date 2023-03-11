<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\DessertController;
use App\Http\Controllers\BoissonController;



Route::resource('personnels',PersonnelController::class);
Route::resource('plats',PlatController::class);
Route::resource('desserts',DessertController::class);
Route::resource('boissons',BoissonController::class);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
