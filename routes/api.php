<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Api\CourierApiController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\SearchStatsController;

// Public API endpoints (no authentication required)
Route::prefix('public')->group(function () {
    Route::get('/search-stats', [SearchStatsController::class, 'getSearchStatistics'])->name('api.public.search.stats');
    Route::get('/search-analytics', [SearchStatsController::class, 'getDetailedAnalytics'])->name('api.public.search.analytics');
    Route::get('/live-stats', [SearchStatsController::class, 'getLiveStats'])->name('api.public.live.stats');
});

// Protected API endpoints (require API subscription authentication)
Route::middleware(['api.subscription'])->group(function () {
    // User info endpoint
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $request->user(),
                'subscription' => $request->user()->activeSubscription,
                'api_usage_today' => $request->user()->getTodayApiUsage(),
                'remaining_requests' => $request->user()->getRemainingDailyRequests(),
            ]
        ]);
    });

    // Courier endpoints
    Route::post('/customer/check', [CourierApiController::class, 'check'])->name('api.customer.check');
    
    // Customer review endpoints
    Route::post('/customer-review', [CustomerReviewController::class, 'storeFromApi'])->name('api.customer.review.store');
    Route::get('/customer-reviews/{phone}', [CustomerReviewController::class, 'listFromApi'])->name('api.customer.review.list');
    Route::get('/customer-reviews-with-reports/{phone}', [CustomerReviewController::class, 'getReviewsWithReportsFromApi'])->name('api.customer.review.list.reports');
    
    // API usage endpoints
    Route::get('/usage/stats', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'today_usage' => $user->getTodayApiUsage(),
                'monthly_usage' => $user->getMonthlyApiUsage(),
                'daily_limit' => $user->getDailyRequestLimit(),
                'remaining_today' => $user->getRemainingDailyRequests(),
                'subscription' => $user->activeSubscription ? [
                    'plan_name' => $user->activeSubscription->plan->name,
                    'expires_at' => $user->activeSubscription->expires_at,
                    'days_remaining' => $user->activeSubscription->getDaysRemainingAttribute(),
                ] : null
            ]
        ]);
    });
});