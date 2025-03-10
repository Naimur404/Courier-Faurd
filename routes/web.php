<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\VerifyRequestOrigin;

Route::get('/', [HomeController::class, 'home']);
Route::post('/courier-check', [CourierController::class, 'check'])->name('courier.check')->middleware([VerifyRequestOrigin::class]);

// Route::post('/customer-list', [CourierController::class, 'list'])->name('customer.list')->middleware([VerifyRequestOrigin::class]);
Route::get('/customer', [CourierController::class, 'showTokenForm'])->name('customer.form')->middleware([VerifyRequestOrigin::class]);
Route::post('customer-review', [CustomerReviewController::class, 'store'])->name('customer.review.store')->middleware([VerifyRequestOrigin::class]);
Route::get('customer-reviews/{phone}', [CustomerReviewController::class, 'list'])->name('customer.review.list')->middleware([VerifyRequestOrigin::class]);


Route::post('/authenticate', [CourierController::class, 'authenticate']);
Route::post('/customer-data', [CourierController::class, 'getCustomerData']);

// Keep the original route for backward compatibility
Route::post('/customer-list', [CourierController::class, 'list']);


Route::get('/download', [DownloadController::class, 'index'])->name('download.page');
Route::get('/download-apk', [DownloadController::class, 'download2'])->name('download.apk2');

Route::post('/track-download-intent', [DownloadController::class, 'trackIntent'])->name('track.download.intent');
Route::get('/download-app', [DownloadController::class, 'download'])->name('download.apk');

Route::post('/track-download-intent', [DownloadController::class, 'trackDownloadIntent'])->name('track.download.intent');

// Download CSV data
Route::get('/download-csv', [DownloadController::class, 'downloadCsv'])->name('download.csv');