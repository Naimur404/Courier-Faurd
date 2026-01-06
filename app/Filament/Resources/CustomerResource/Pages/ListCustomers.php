<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
    
    // Disable query caching for real-time data
    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'customers';
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
