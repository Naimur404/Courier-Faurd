<?php

namespace App\Filament\Resources\WebsiteSubscriptionResource\Pages;

use App\Filament\Resources\WebsiteSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\WebsiteSubscription;

class ListWebsiteSubscriptions extends ListRecords
{
    protected static string $resource = WebsiteSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            
            'pending' => Tab::make('Pending Verification')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('verification_status', WebsiteSubscription::VERIFICATION_PENDING))
                ->badge(WebsiteSubscription::where('verification_status', WebsiteSubscription::VERIFICATION_PENDING)->count())
                ->badgeColor('warning'),
            
            'verified' => Tab::make('Verified')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('verification_status', WebsiteSubscription::VERIFICATION_VERIFIED))
                ->badge(WebsiteSubscription::where('verification_status', WebsiteSubscription::VERIFICATION_VERIFIED)->count())
                ->badgeColor('success'),
            
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WebsiteSubscription::STATUS_ACTIVE)
                    ->where('expires_at', '>', now()))
                ->badge(WebsiteSubscription::where('status', WebsiteSubscription::STATUS_ACTIVE)
                    ->where('expires_at', '>', now())->count())
                ->badgeColor('success'),
            
            'expired' => Tab::make('Expired')
                ->modifyQueryUsing(fn (Builder $query) => $query->where(function($q) {
                    $q->where('status', WebsiteSubscription::STATUS_EXPIRED)
                      ->orWhere(function($subQuery) {
                          $subQuery->where('status', WebsiteSubscription::STATUS_ACTIVE)
                                   ->where('expires_at', '<=', now());
                      });
                }))
                ->badge(WebsiteSubscription::where(function($q) {
                    $q->where('status', WebsiteSubscription::STATUS_EXPIRED)
                      ->orWhere(function($subQuery) {
                          $subQuery->where('status', WebsiteSubscription::STATUS_ACTIVE)
                                   ->where('expires_at', '<=', now());
                      });
                })->count())
                ->badgeColor('danger'),
            
            'expires_soon' => Tab::make('Expires Soon')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WebsiteSubscription::STATUS_ACTIVE)
                    ->whereBetween('expires_at', [now(), now()->addDays(7)]))
                ->badge(WebsiteSubscription::where('status', WebsiteSubscription::STATUS_ACTIVE)
                    ->whereBetween('expires_at', [now(), now()->addDays(7)])->count())
                ->badgeColor('warning'),
        ];
    }
}