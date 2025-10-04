<?php

namespace App\Filament\Resources\WebsiteSubscriptionResource\Pages;

use App\Filament\Resources\WebsiteSubscriptionResource;
use Illuminate\Support\Facades\Auth;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use App\Models\WebsiteSubscription;

class ViewWebsiteSubscription extends ViewRecord
{
    protected static string $resource = WebsiteSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            Actions\Action::make('verify')
                ->label('Verify Subscription')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => $this->record->isPending())
                ->form([
                    \Filament\Forms\Components\Textarea::make('admin_notes')
                        ->label('Admin Notes')
                        ->placeholder('Add notes about verification...')
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    $this->record->verify(Auth::id(), $data['admin_notes'] ?? null);
                    
                    Notification::make()
                        ->title('Subscription verified successfully')
                        ->success()
                        ->send();
                    
                    $this->refreshFormData(['verification_status', 'verified_by', 'verified_at', 'admin_notes']);
                }),

            Actions\Action::make('reject')
                ->label('Reject Subscription')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (): bool => $this->record->isPending())
                ->form([
                    \Filament\Forms\Components\Textarea::make('admin_notes')
                        ->label('Rejection Reason')
                        ->placeholder('Please provide reason for rejection...')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    $this->record->reject(Auth::id(), $data['admin_notes']);
                    
                    Notification::make()
                        ->title('Subscription rejected')
                        ->success()
                        ->send();
                    
                    $this->refreshFormData(['verification_status', 'verified_by', 'verified_at', 'admin_notes']);
                }),
        ];
    }
}