<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortController;

Route::get('/create-port',[PortController::class,'store']);

Route::get('/nearby-ports',[PortController::class,'nearbyPorts']);


Route::get('/', function () {
    return view('welcome');
});
