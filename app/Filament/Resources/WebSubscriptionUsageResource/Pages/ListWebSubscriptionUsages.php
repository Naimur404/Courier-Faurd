<?php

namespace App\Filament\Resources\WebSubscriptionUsageResource\Pages;

use App\Filament\Resources\WebSubscriptionUsageResource;
use App\Filament\Resources\WebSubscriptionUsageResource\Widgets\UsageStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListWebSubscriptionUsages extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = WebSubscriptionUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - records are auto-generated
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UsageStatsOverview::class,
        ];
    }
}
