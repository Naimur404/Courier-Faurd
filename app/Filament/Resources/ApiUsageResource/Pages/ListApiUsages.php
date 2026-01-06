<?php

namespace App\Filament\Resources\ApiUsageResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ApiUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ApiUsage;

class ListApiUsages extends ListRecords
{
    protected static string $resource = ApiUsageResource::class;
    
    // Set default sort column and direction
    protected ?string $defaultTableSortColumn = 'created_at';
    protected ?string $defaultTableSortDirection = 'desc';
    
    // Disable query caching for real-time data
    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'api-usages';
    }
    
    // Force ordering by created_at DESC to show latest first
    protected function getTableQuery(): Builder
    {
        return ApiUsage::query()->orderBy('created_at', 'desc');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->action(fn () => $this->resetTable()),
            CreateAction::make(),
        ];
    }
}
