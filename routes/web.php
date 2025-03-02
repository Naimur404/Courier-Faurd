<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Middleware\VerifyRequestOrigin;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/courier-check', [CourierController::class, 'check'])->name('courier.check')->middleware([VerifyRequestOrigin::class]);

Route::post('/customer-list', [CourierController::class, 'list'])->name('customer.list')->middleware([VerifyRequestOrigin::class]);
Route::get('/customer', [CourierController::class, 'showTokenForm'])->name('customer.form')->middleware([VerifyRequestOrigin::class]);
Route::post('customer-review', [CustomerReviewController::class, 'store'])->name('customer.review.store')->middleware([VerifyRequestOrigin::class]);
Route::get('customer-reviews/{phone}', [CustomerReviewController::class, 'list'])->name('customer.review.list')->middleware([VerifyRequestOrigin::class]);