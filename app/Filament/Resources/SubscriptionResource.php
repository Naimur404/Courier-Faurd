<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\SubscriptionResource\RelationManagers\ApiKeysRelationManager;
use App\Filament\Resources\SubscriptionResource\Pages\ListSubscriptions;
use App\Filament\Resources\SubscriptionResource\Pages\CreateSubscription;
use App\Filament\Resources\SubscriptionResource\Pages\ViewSubscription;
use App\Filament\Resources\SubscriptionResource\Pages\EditSubscription;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';
    
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';
    
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('plan_id')
                            ->relationship('plan', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->options([
                                Subscription::STATUS_PENDING => 'Pending',
                                Subscription::STATUS_ACTIVE => 'Active',
                                Subscription::STATUS_EXPIRED => 'Expired',
                                Subscription::STATUS_CANCELLED => 'Cancelled',
                            ])
                            ->required()
                            ->default(Subscription::STATUS_PENDING)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state === Subscription::STATUS_ACTIVE && !request()->route('record')) {
                                    $set('starts_at', now());
                                    $set('activated_at', now());
                                }
                            }),
                    ])
                    ->columns(3),
                
                Section::make('Payment Information')
                    ->schema([
                        TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->maxLength(255),
                        Select::make('payment_method')
                            ->options([
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'rocket' => 'Rocket',
                                'upay' => 'Upay',
                                'bank_transfer' => 'Bank Transfer',
                                'cash' => 'Cash',
                                'card' => 'Credit/Debit Card',
                            ])
                            ->required()
                            ->searchable(),
                        TextInput::make('amount_paid')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->step(0.01),
                    ])
                    ->columns(3),
                
                Section::make('Timeline')
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->seconds(false),
                        DateTimePicker::make('expires_at')
                            ->label('Expiry Date')
                            ->seconds(false),
                        DateTimePicker::make('activated_at')
                            ->label('Activated Date')
                            ->seconds(false),
                    ])
                    ->columns(3),
                
                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->description(function (Subscription $record): ?string {
                        $apiKeysCount = $record->user->apiKeys()->count();
                        return $apiKeysCount > 0 ? "{$apiKeysCount} API key(s)" : 'No API keys';
                    }),
                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
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
                TextColumn::make('payment_method')
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
                TextColumn::make('amount_paid')
                    ->label('Amount')
                    ->money('BDT')
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->label('Start Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('expires_at')
                    ->label('Expiry Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->description(function (Subscription $record): ?string {
                        if ($record->status === Subscription::STATUS_ACTIVE && $record->expires_at) {
                            $daysRemaining = $record->getDaysRemainingAttribute();
                            if ($daysRemaining > 0) {
                                return $daysRemaining . ' days remaining';
                            } elseif ($daysRemaining === 0) {
                                return 'Expires today';
                            } else {
                                return 'Expired ' . abs($daysRemaining) . ' days ago';
                            }
                        }
                        return null;
                    }),
                TextColumn::make('activated_at')
                    ->label('Activated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        Subscription::STATUS_PENDING => 'Pending',
                        Subscription::STATUS_ACTIVE => 'Active',
                        Subscription::STATUS_EXPIRED => 'Expired',
                        Subscription::STATUS_CANCELLED => 'Cancelled',
                    ]),
                SelectFilter::make('payment_method')
                    ->options([
                        'bkash' => 'bKash',
                        'nagad' => 'Nagad',
                        'rocket' => 'Rocket',
                        'upay' => 'Upay',
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                        'card' => 'Credit/Debit Card',
                    ]),
                Filter::make('active_subscriptions')
                    ->label('Active Only')
                    ->query(fn (Builder $query): Builder => $query->where('status', Subscription::STATUS_ACTIVE)),
                Filter::make('expired_subscriptions')
                    ->label('Expired Only')
                    ->query(fn (Builder $query): Builder => $query->where('status', Subscription::STATUS_EXPIRED)),
            ])
            ->recordActions([
                Action::make('toggle_status')
                    ->label(fn (Subscription $record): string => 
                        $record->status === Subscription::STATUS_ACTIVE ? 'Deactivate' : 'Activate'
                    )
                    ->icon(fn (Subscription $record): string => 
                        $record->status === Subscription::STATUS_ACTIVE ? 'heroicon-o-pause-circle' : 'heroicon-o-play-circle'
                    )
                    ->color(fn (Subscription $record): string => 
                        $record->status === Subscription::STATUS_ACTIVE ? 'warning' : 'success'
                    )
                    ->requiresConfirmation()
                    ->modalHeading(fn (Subscription $record): string => 
                        $record->status === Subscription::STATUS_ACTIVE ? 'Deactivate Subscription' : 'Activate Subscription'
                    )
                    ->modalDescription(fn (Subscription $record): string => 
                        $record->status === Subscription::STATUS_ACTIVE 
                            ? 'Are you sure you want to deactivate this subscription? The user will lose access immediately.'
                            : 'Are you sure you want to activate this subscription? The user will gain access immediately.'
                    )
                    ->action(function (Subscription $record): void {
                        if ($record->status === Subscription::STATUS_ACTIVE) {
                            $record->update([
                                'status' => Subscription::STATUS_CANCELLED,
                            ]);
                            
                            Notification::make()
                                ->title('Subscription Deactivated')
                                ->body('The subscription has been successfully deactivated.')
                                ->success()
                                ->send();
                        } else {
                            $record->activate();
                            
                            Notification::make()
                                ->title('Subscription Activated')
                                ->body('The subscription has been successfully activated.')
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(fn (Subscription $record): bool => 
                        in_array($record->status, [Subscription::STATUS_ACTIVE, Subscription::STATUS_PENDING, Subscription::STATUS_CANCELLED])
                    ),
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('activate_selected')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-play-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Activate Selected Subscriptions')
                        ->modalDescription('Are you sure you want to activate the selected subscriptions?')
                        ->action(function (Collection $records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status !== Subscription::STATUS_ACTIVE) {
                                    $record->activate();
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->title('Subscriptions Activated')
                                ->body("{$count} subscription(s) have been successfully activated.")
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('deactivate_selected')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-pause-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Selected Subscriptions')
                        ->modalDescription('Are you sure you want to deactivate the selected subscriptions?')
                        ->action(function (Collection $records): void {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === Subscription::STATUS_ACTIVE) {
                                    $record->update(['status' => Subscription::STATUS_CANCELLED]);
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->title('Subscriptions Deactivated')
                                ->body("{$count} subscription(s) have been successfully deactivated.")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ApiKeysRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
            'create' => CreateSubscription::route('/create'),
            'view' => ViewSubscription::route('/{record}'),
            'edit' => EditSubscription::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', Subscription::STATUS_ACTIVE)->count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
