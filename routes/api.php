<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CustomerReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/courier-check', [CourierController::class, 'checkFromApi'])->name('courier.checkApi');
Route::post('customer-review', [CustomerReviewController::class, 'store'])->name('customer.reviewApi.store');
Route::get('customer-reviews/{phone}', [CustomerReviewController::class, 'list'])->name('customer.reviewApi.list');