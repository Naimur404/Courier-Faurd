<?php

namespace App\Filament\Resources\WebSubscriptionUsageResource\Widgets;

use App\Models\WebSubscriptionUsage;
use App\Models\BlockedIp;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class UsageStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::now('Asia/Dhaka')->toDateString();
        $yesterday = Carbon::now('Asia/Dhaka')->subDay()->toDateString();
        $thisWeekStart = Carbon::now('Asia/Dhaka')->startOfWeek()->toDateString();
        $thisMonthStart = Carbon::now('Asia/Dhaka')->startOfMonth()->toDateString();

        // Today's stats
        $todayHits = WebSubscriptionUsage::where('usage_date', $today)->sum('hit_count');
        $todayUsers = WebSubscriptionUsage::where('usage_date', $today)->distinct('user_id')->count('user_id');

        // Yesterday's stats for comparison
        $yesterdayHits = WebSubscriptionUsage::where('usage_date', $yesterday)->sum('hit_count');

        // This week's stats
        $weekHits = WebSubscriptionUsage::where('usage_date', '>=', $thisWeekStart)->sum('hit_count');

        // This month's stats
        $monthHits = WebSubscriptionUsage::where('usage_date', '>=', $thisMonthStart)->sum('hit_count');
        $monthUsers = WebSubscriptionUsage::where('usage_date', '>=', $thisMonthStart)->distinct('user_id')->count('user_id');

        // Blocked IPs count
        $blockedIps = BlockedIp::where('is_active', true)->count();

        // Top user today
        $topUserToday = WebSubscriptionUsage::where('usage_date', $today)
            ->with('user')
            ->orderBy('hit_count', 'desc')
            ->first();

        // Calculate trend
        $hitsTrend = $yesterdayHits > 0 
            ? round((($todayHits - $yesterdayHits) / $yesterdayHits) * 100, 1) 
            : ($todayHits > 0 ? 100 : 0);

        return [
            Stat::make('Today\'s Hits', number_format($todayHits))
                ->description($hitsTrend >= 0 ? "+{$hitsTrend}% from yesterday" : "{$hitsTrend}% from yesterday")
                ->descriptionIcon($hitsTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($hitsTrend >= 0 ? 'success' : 'danger')
                ->chart([
                    $yesterdayHits,
                    $todayHits,
                ]),

            Stat::make('Active Subscribers Today', $todayUsers)
                ->description('Users who made searches today')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('This Week', number_format($weekHits))
                ->description('Total hits this week')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('This Month', number_format($monthHits))
                ->description("{$monthUsers} unique users")
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Blocked IPs', $blockedIps)
                ->description('Currently active blocks')
                ->descriptionIcon('heroicon-m-shield-exclamation')
                ->color('danger'),

            Stat::make('Top User Today', $topUserToday?->user?->name ?? 'N/A')
                ->description($topUserToday ? "{$topUserToday->hit_count} hits" : 'No activity yet')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }
}
