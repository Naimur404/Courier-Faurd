<?php

namespace App\Filament\Resources\ApiUsageResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ApiUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApiUsages extends ListRecords
{
    protected static string $resource = ApiUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
