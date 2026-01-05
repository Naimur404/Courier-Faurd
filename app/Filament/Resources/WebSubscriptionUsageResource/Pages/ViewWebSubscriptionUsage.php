<?php

namespace App\Filament\Resources\WebSubscriptionUsageResource\Pages;

use App\Filament\Resources\WebSubscriptionUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWebSubscriptionUsage extends ViewRecord
{
    protected static string $resource = WebSubscriptionUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // View only - no edit/delete from here
        ];
    }
}
