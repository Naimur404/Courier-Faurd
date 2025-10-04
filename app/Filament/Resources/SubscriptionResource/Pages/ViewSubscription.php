<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use App\Models\Subscription;

class ViewSubscription extends ViewRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggle_status')
                ->label(fn (): string => 
                    $this->record->status === Subscription::STATUS_ACTIVE ? 'Deactivate' : 'Activate'
                )
                ->icon(fn (): string => 
                    $this->record->status === Subscription::STATUS_ACTIVE ? 'heroicon-o-pause-circle' : 'heroicon-o-play-circle'
                )
                ->color(fn (): string => 
                    $this->record->status === Subscription::STATUS_ACTIVE ? 'warning' : 'success'
                )
                ->requiresConfirmation()
                ->modalHeading(fn (): string => 
                    $this->record->status === Subscription::STATUS_ACTIVE ? 'Deactivate Subscription' : 'Activate Subscription'
                )
                ->modalDescription(fn (): string => 
                    $this->record->status === Subscription::STATUS_ACTIVE 
                        ? 'Are you sure you want to deactivate this subscription? The user will lose access immediately.'
                        : 'Are you sure you want to activate this subscription? The user will gain access immediately.'
                )
                ->action(function (): void {
                    if ($this->record->status === Subscription::STATUS_ACTIVE) {
                        $this->record->update([
                            'status' => Subscription::STATUS_CANCELLED,
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Subscription Deactivated')
                            ->body('The subscription has been successfully deactivated.')
                            ->success()
                            ->send();
                    } else {
                        $this->record->activate();
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Subscription Activated')
                            ->body('The subscription has been successfully activated.')
                            ->success()
                            ->send();
                    }
                })
                ->visible(fn (): bool => 
                    in_array($this->record->status, [Subscription::STATUS_ACTIVE, Subscription::STATUS_PENDING, Subscription::STATUS_CANCELLED])
                ),
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Subscription Overview')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User'),
                        TextEntry::make('plan.name')
                            ->label('Plan'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                Subscription::STATUS_ACTIVE => 'success',
                                Subscription::STATUS_PENDING => 'warning',
                                Subscription::STATUS_EXPIRED => 'danger',
                                Subscription::STATUS_CANCELLED => 'gray',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                Subscription::STATUS_ACTIVE => 'Active',
                                Subscription::STATUS_PENDING => 'Pending',
                                Subscription::STATUS_EXPIRED => 'Expired',
                                Subscription::STATUS_CANCELLED => 'Cancelled',
                                default => ucfirst($state),
                            }),
                    ])
                    ->columns(3),

                Section::make('Payment Information')
                    ->schema([
                        TextEntry::make('transaction_id')
                            ->label('Transaction ID')
                            ->placeholder('Not provided'),
                        TextEntry::make('payment_method')
                            ->label('Payment Method')
                            ->badge()
                            ->color('primary')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'rocket' => 'Rocket',
                                'upay' => 'Upay',
                                'bank_transfer' => 'Bank Transfer',
                                'cash' => 'Cash',
                                'card' => 'Credit/Debit Card',
                                default => ucfirst($state),
                            }),
                        TextEntry::make('amount_paid')
                            ->label('Amount Paid')
                            ->money('BDT'),
                    ])
                    ->columns(3),

                Section::make('Timeline')
                    ->schema([
                        TextEntry::make('starts_at')
                            ->label('Start Date')
                            ->dateTime('M j, Y g:i A')
                            ->placeholder('Not set'),
                        TextEntry::make('expires_at')
                            ->label('Expiry Date')
                            ->dateTime('M j, Y g:i A')
                            ->placeholder('Not set'),
                        TextEntry::make('days_remaining')
                            ->label('Status Info')
                            ->formatStateUsing(function (): ?string {
                                if ($this->record->status === Subscription::STATUS_ACTIVE && $this->record->expires_at) {
                                    $daysRemaining = $this->record->getDaysRemainingAttribute();
                                    if ($daysRemaining > 0) {
                                        return $daysRemaining . ' days remaining';
                                    } elseif ($daysRemaining === 0) {
                                        return 'Expires today';
                                    } else {
                                        return 'Expired ' . abs($daysRemaining) . ' days ago';
                                    }
                                }
                                return 'Not applicable';
                            })
                            ->badge()
                            ->color(function (): string {
                                if ($this->record->status === Subscription::STATUS_ACTIVE && $this->record->expires_at) {
                                    $daysRemaining = $this->record->getDaysRemainingAttribute();
                                    if ($daysRemaining > 7) {
                                        return 'success';
                                    } elseif ($daysRemaining > 0) {
                                        return 'warning';
                                    } else {
                                        return 'danger';
                                    }
                                }
                                return 'gray';
                            }),
                        TextEntry::make('activated_at')
                            ->label('Activated Date')
                            ->dateTime('M j, Y g:i A')
                            ->placeholder('Not activated'),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->placeholder('No notes')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime('M j, Y g:i A'),
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('M j, Y g:i A'),
                    ])
                    ->columns(2),
            ]);
    }
}