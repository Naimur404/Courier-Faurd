<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Middleware\VerifyRequestOrigin;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/courier-check', [CourierController::class, 'check'])->name('courier.check')->middleware([VerifyRequestOrigin::class]);

Route::post('/customer-list', [CourierController::class, 'list'])->name('customer.list')->middleware([VerifyRequestOrigin::class]);
Route::get('/customer', [CourierController::class, 'showTokenForm'])->name('customer.form')->middleware([VerifyRequestOrigin::class]);