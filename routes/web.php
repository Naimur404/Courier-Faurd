<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/courier-check', [CourierController::class, 'check'])->name('courier.check');