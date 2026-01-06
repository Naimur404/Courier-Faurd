<?php

namespace App\Filament\Resources\ApiUsageResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ApiUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApiUsages extends ListRecords
{
    protected static string $resource = ApiUsageResource::class;
    
    // Disable query caching for real-time data
    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'api-usages';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->resetTable()),
        ];
    }
}
