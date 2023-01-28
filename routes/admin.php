<?php

use App\Http\Controllers\Admin\AtencioneController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::resource('/', HomeController::class)->names('admin');

Route::resource('atenciones', AtencioneController::class)->names('admin.atenciones');
Route::resource('clientes', ClienteController::class)->names('admin.clientes');