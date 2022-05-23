<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\ManufacturesController;

Route::resource('/', HomeController::class)->except([
    'create', 'store', 'show', 'edit', 'update', 'destroy'
]);
Route::resource('/goods', GoodsController::class)->except([
    'show'
]);
Route::resource('/manufactures', ManufacturesController::class)->except([
    'show'
]);
