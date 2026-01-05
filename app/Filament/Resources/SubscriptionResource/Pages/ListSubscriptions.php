<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\SubscriptionResource;
use App\Models\Subscription;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Subscription')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Subscriptions'),
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Subscription::STATUS_ACTIVE))
                ->badge(Subscription::where('status', Subscription::STATUS_ACTIVE)->count()),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Subscription::STATUS_PENDING))
                ->badge(Subscription::where('status', Subscription::STATUS_PENDING)->count()),
            'expired' => Tab::make('Expired')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Subscription::STATUS_EXPIRED))
                ->badge(Subscription::where('status', Subscription::STATUS_EXPIRED)->count()),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Subscription::STATUS_CANCELLED))
                ->badge(Subscription::where('status', Subscription::STATUS_CANCELLED)->count()),
        ];
    }
}
