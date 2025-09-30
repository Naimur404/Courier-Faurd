<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchStatsController extends Controller
{
    /**
     * Get search statistics for the welcome page
     */
    public function getSearchStatistics()
    {
        // Last 1 hour searches
        $lastHourSearches = Customer::where('last_searched_at', '>=', Carbon::now()->subHour())
            ->count();
        
        // Last 24 hours searches
        $lastDaySearches = Customer::where('last_searched_at', '>=', Carbon::now()->subDay())
            ->count();
        
        // All time searches (total count of all searches)
        $allTimeSearches = Customer::sum('count');
        
        // Total unique numbers searched
        $uniqueNumbersSearched = Customer::count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'last_hour' => $lastHourSearches,
                'last_day' => $lastDaySearches,
                'all_time' => $allTimeSearches,
                'unique_numbers' => $uniqueNumbersSearched
            ]
        ]);
    }
    
    /**
     * Get detailed search analytics
     */
    public function getDetailedAnalytics()
    {
        $now = Carbon::now();
        
        // Searches by platform (web vs app)
        $webSearches = Customer::where('search_by', 'web')->sum('count');
        $appSearches = Customer::where('search_by', 'app')->sum('count');
        
        // Most searched numbers (top 10)
        $topSearchedNumbers = Customer::orderBy('count', 'desc')
            ->take(10)
            ->get(['phone', 'count']);
        
        // Recent searches (last 50)
        $recentSearches = Customer::orderBy('last_searched_at', 'desc')
            ->take(50)
            ->get(['phone', 'last_searched_at', 'count']);
        
        // Daily search trend for last 7 days
        $dailyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            
            $searchCount = Customer::whereBetween('last_searched_at', [$startOfDay, $endOfDay])
                ->count();
            
            $dailyTrend[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'searches' => $searchCount
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'platform_breakdown' => [
                    'web' => $webSearches,
                    'app' => $appSearches
                ],
                'top_searched' => $topSearchedNumbers,
                'recent_searches' => $recentSearches,
                'daily_trend' => $dailyTrend
            ]
        ]);
    }
    
    /**
     * Get live search counter (for real-time updates)
     */
    public function getLiveStats()
    {
        $allTimeSearches = Customer::sum('count');
        $uniqueNumbers = Customer::count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_searches' => $allTimeSearches,
                'unique_numbers' => $uniqueNumbers,
                'timestamp' => now()->toISOString()
            ]
        ]);
    }
}