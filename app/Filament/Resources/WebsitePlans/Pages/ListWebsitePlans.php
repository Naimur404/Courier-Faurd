<?php

namespace App\Filament\Resources\WebsitePlans\Pages;

use App\Filament\Resources\WebsitePlans\WebsitePlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWebsitePlans extends ListRecords
{
    protected static string $resource = WebsitePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
