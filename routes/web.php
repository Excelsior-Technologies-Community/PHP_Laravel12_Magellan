<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortController;

Route::get('/', [PortController::class, 'index']);

Route::get('/create-port', [PortController::class, 'store']);

Route::delete('/delete-port/{id}', [PortController::class, 'destroy']);

Route::get('/nearby-ports', [PortController::class, 'nearbyPorts']);