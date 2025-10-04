<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\CustomerReview;
use App\Models\AppDownloadTrack;
use App\Models\ApiUsage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class SearchStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $bangladeshTime = Carbon::now('Asia/Dhaka');
        
        // Search statistics
        $todaySearches = Customer::whereDate('last_searched_at', $bangladeshTime->toDateString())->sum('count');
        $totalSearches = Customer::sum('count');
        $uniqueNumbers = Customer::count();
        
        // Review statistics
        $totalReviews = CustomerReview::count();
        $reportsCount = CustomerReview::where('rating', 1.0)->count();
        
        // Download statistics
        $totalDownloads = AppDownloadTrack::where('status', 'completed')->count();
        $todayDownloads = AppDownloadTrack::where('status', 'completed')
                                         ->whereDate('created_at', $bangladeshTime->toDateString())
                                         ->count();
        
        // API usage statistics
        $totalApiUsage = ApiUsage::count();
        $todayApiUsage = ApiUsage::whereDate('created_at', $bangladeshTime->toDateString())->count();

        return [
            Stat::make('Total Searches', number_format($totalSearches))
                ->description('All-time courier searches')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('success'),
                
            Stat::make("Today's Searches", number_format($todaySearches))
                ->description('Searches today (Bangladesh time)')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
                
            Stat::make('Unique Numbers', number_format($uniqueNumbers))
                ->description('Unique phone numbers searched')
                ->descriptionIcon('heroicon-m-phone')
                ->color('info'),
                
            Stat::make('Customer Reviews', number_format($totalReviews))
                ->description("{$reportsCount} reports included")
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('warning'),
                
            Stat::make('App Downloads', number_format($totalDownloads))
                ->description("{$todayDownloads} downloads today")
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('danger'),
                
            Stat::make('API Requests', number_format($totalApiUsage))
                ->description("{$todayApiUsage} requests today")
                ->descriptionIcon('heroicon-m-bolt')
                ->color('gray'),
        ];
    }
    
    protected function getColumns(): int
    {
        return 3;
    }
}