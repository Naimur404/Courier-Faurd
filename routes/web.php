<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchStatsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiDocumentationController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\WebsiteSubscriptionController;
use App\Http\Middleware\VerifyRequestOrigin;

// Public routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Offline page for PWA
Route::get('/offline', function () {
    return inertia('Offline');
})->name('offline');

// Pricing routes
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// Website Subscription routes (separate from API subscriptions)
Route::get('/website-subscriptions', [WebsiteSubscriptionController::class, 'index'])->name('website.subscriptions');
Route::get('/api/website-subscriptions/plans', [WebsiteSubscriptionController::class, 'getPlans'])->name('website.subscriptions.plans');
Route::middleware('auth')->group(function () {
    Route::get('/website-subscriptions/subscribe/{plan}', [WebsiteSubscriptionController::class, 'subscribe'])->name('website.subscriptions.subscribe');
    Route::post('/website-subscriptions/subscribe/{plan}', [WebsiteSubscriptionController::class, 'processSubscription'])->name('website.subscriptions.process');
    Route::get('/api/website-subscriptions/status', [WebsiteSubscriptionController::class, 'getStatus'])->name('website.subscriptions.status');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Subscription routes
Route::middleware('auth')->group(function () {
    Route::get('/pricing/subscribe/{plan}', [PricingController::class, 'subscribe'])->name('pricing.subscribe');
    Route::post('/pricing/subscribe/{plan}', [PricingController::class, 'processSubscription'])->name('pricing.process-subscription');
});

// Dashboard routes (API users only)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/generate-api-key', [DashboardController::class, 'generateApiKey'])->name('dashboard.generate-api-key');
    Route::patch('/dashboard/api-key/{apiKey}/toggle', [DashboardController::class, 'toggleApiKey'])->name('dashboard.toggle-api-key');
    Route::delete('/dashboard/api-key/{apiKey}', [DashboardController::class, 'deleteApiKey'])->name('dashboard.delete-api-key');
    Route::get('/dashboard/api-docs', [DashboardController::class, 'apiDocs'])->name('dashboard.api-docs');
});

// API Documentation (public access)
Route::get('/api/documentation', [ApiDocumentationController::class, 'index'])->name('api.documentation');





// Courier tracking routes with IP rate limiting (5 searches per day per IP)
Route::post('/courier-check', [CourierController::class, 'check'])->name('courier.check')->middleware([VerifyRequestOrigin::class, 'ip.rate.limit']);
Route::get('/customer', [CourierController::class, 'showTokenForm'])->name('customer.form')->middleware([VerifyRequestOrigin::class]);
Route::post('customer-review', [CustomerReviewController::class, 'store'])->name('customer.review.store')->middleware([VerifyRequestOrigin::class]);
Route::get('customer-reviews/{phone}', [CustomerReviewController::class, 'list'])->name('customer.review.list')->middleware([VerifyRequestOrigin::class]);

Route::post('/authenticate', [CourierController::class, 'authenticate']);
Route::post('/customer-data', [CourierController::class, 'getCustomerData']);

// Keep the original route for backward compatibility
Route::post('/customer-list', [CourierController::class, 'list']);

// Download routes
Route::get('/download', [DownloadController::class, 'index'])->name('download.page');
Route::get('/download-apk', [DownloadController::class, 'download2'])->name('download.apk2');
Route::post('/track-download-intent', [DownloadController::class, 'trackIntent'])->name('track.download.intent');
Route::get('/download-app', [DownloadController::class, 'download'])->name('download.apk');
Route::post('/track-download-intent', [DownloadController::class, 'trackDownloadIntent'])->name('track.download.intent');
Route::get('/download-csv', [DownloadController::class, 'downloadCsv'])->name('download.csv');

// Search Statistics Routes (Public access for real-time stats)
Route::get('/api/search-stats', [SearchStatsController::class, 'getSearchStatistics'])->name('search.stats');
Route::get('/api/search-analytics', [SearchStatsController::class, 'getDetailedAnalytics'])->name('search.analytics');
Route::get('/api/live-stats', [SearchStatsController::class, 'getLiveStats'])->name('live.stats');