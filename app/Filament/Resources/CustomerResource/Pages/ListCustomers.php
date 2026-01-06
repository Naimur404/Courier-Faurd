<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Customer;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
    
    // Set default sort column and direction
    protected ?string $defaultTableSortColumn = 'last_searched_at';
    protected ?string $defaultTableSortDirection = 'desc';
    
    // Disable query caching for real-time data
    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'customers';
    }
    
    // Force ordering by last_searched_at DESC to show latest first
    protected function getTableQuery(): Builder
    {
        return Customer::query()->orderBy('last_searched_at', 'desc');
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
