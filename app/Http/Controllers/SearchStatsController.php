<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchStatsController extends Controller
{
    /**
     * Get search statistics for the welcome page with Bangladesh timezone (GMT+6)
     */
    public function getSearchStatistics()
    {
        // Set timezone to Bangladesh (Asia/Dhaka - GMT+6)
        $bangladeshTime = Carbon::now('Asia/Dhaka');
        
        // Last 1 hour searches (Bangladesh time)
        $oneHourAgo = $bangladeshTime->copy()->subHour();
        $lastHourSearches = Customer::where('last_searched_at', '>=', $oneHourAgo->utc())
            ->count();
        
        // Today's searches (from 12:00 AM Bangladesh time today)
        $startOfTodayBD = $bangladeshTime->copy()->startOfDay(); // 12:00 AM Bangladesh time
        $todaySearches = Customer::where('last_searched_at', '>=', $startOfTodayBD->utc())
            ->count();
        
        // All time searches (total count of all searches)
        $allTimeSearches = Customer::sum('count');
        
        // Total unique numbers searched
        $uniqueNumbersSearched = Customer::count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'last_hour' => $lastHourSearches,
                'today' => $todaySearches,
                'all_time' => $allTimeSearches,
                'unique_numbers' => $uniqueNumbersSearched,
                'bangladesh_time' => $bangladeshTime->format('Y-m-d H:i:s'),
                'timezone' => 'Asia/Dhaka (GMT+6)'
            ]
        ]);
    }
    
    /**
     * Get detailed search analytics with Bangladesh timezone (GMT+6)
     */
    public function getDetailedAnalytics()
    {
        $bangladeshTime = Carbon::now('Asia/Dhaka');
        
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
        
        // Daily search trend for last 7 days (Bangladesh timezone)
        $dailyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $bangladeshTime->copy()->subDays($i);
            $startOfDay = $date->copy()->startOfDay(); // 12:00 AM Bangladesh time
            $endOfDay = $date->copy()->endOfDay(); // 11:59 PM Bangladesh time
            
            $searchCount = Customer::whereBetween('last_searched_at', [$startOfDay->utc(), $endOfDay->utc()])
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
                'daily_trend' => $dailyTrend,
                'timezone' => 'Asia/Dhaka (GMT+6)'
            ]
        ]);
    }
    
    /**
     * Get live search counter (for real-time updates) with Bangladesh timezone (GMT+6)
     */
    public function getLiveStats()
    {
        $allTimeSearches = Customer::sum('count');
        $uniqueNumbers = Customer::count();
        $bangladeshTime = Carbon::now('Asia/Dhaka');
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_searches' => $allTimeSearches,
                'unique_numbers' => $uniqueNumbers,
                'timestamp' => $bangladeshTime->toISOString(),
                'bangladesh_time' => $bangladeshTime->format('Y-m-d H:i:s'),
                'timezone' => 'Asia/Dhaka (GMT+6)'
            ]
        ]);
    }
}