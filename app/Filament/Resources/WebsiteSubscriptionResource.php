<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\WebsiteSubscriptionResource\Pages\ListWebsiteSubscriptions;
use App\Filament\Resources\WebsiteSubscriptionResource\Pages\CreateWebsiteSubscription;
use App\Filament\Resources\WebsiteSubscriptionResource\Pages\ViewWebsiteSubscription;
use App\Filament\Resources\WebsiteSubscriptionResource\Pages\EditWebsiteSubscription;
use App\Filament\Resources\WebsiteSubscriptionResource\Pages;
use App\Models\WebsiteSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;

class WebsiteSubscriptionResource extends Resource
{
    protected static ?string $model = WebsiteSubscription::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static string | \UnitEnum | null $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Website Subscriptions';

    protected static ?string $pluralModelLabel = 'Website Subscriptions';

    protected static ?string $modelLabel = 'Website Subscription';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Select::make('plan_type')
                            ->options([
                                WebsiteSubscription::PLAN_DAILY => 'Daily Plan (৳20)',
                                WebsiteSubscription::PLAN_WEEKLY => '15 Days Plan (৳50)',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state === WebsiteSubscription::PLAN_DAILY) {
                                    $set('amount', WebsiteSubscription::DAILY_PRICE);
                                    $set('expires_at', now()->addDay());
                                } elseif ($state === WebsiteSubscription::PLAN_WEEKLY) {
                                    $set('amount', WebsiteSubscription::WEEKLY_PRICE);
                                    $set('expires_at', now()->addDays(WebsiteSubscription::WEEKLY_DAYS));
                                }
                            }),
                        
                        TextInput::make('amount')
                            ->numeric()
                            ->prefix('৳')
                            ->required()
                            ->step(0.01),
                        
                        DateTimePicker::make('starts_at')
                            ->required()
                            ->default(now()),
                        
                        DateTimePicker::make('expires_at')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Status & Verification')
                    ->schema([
                        Select::make('status')
                            ->options([
                                WebsiteSubscription::STATUS_ACTIVE => 'Active',
                                WebsiteSubscription::STATUS_EXPIRED => 'Expired',
                                WebsiteSubscription::STATUS_CANCELLED => 'Cancelled',
                            ])
                            ->required()
                            ->default(WebsiteSubscription::STATUS_ACTIVE),
                        
                        Select::make('verification_status')
                            ->options([
                                WebsiteSubscription::VERIFICATION_PENDING => 'Pending Verification',
                                WebsiteSubscription::VERIFICATION_VERIFIED => 'Verified',
                                WebsiteSubscription::VERIFICATION_REJECTED => 'Rejected',
                            ])
                            ->required()
                            ->default(WebsiteSubscription::VERIFICATION_PENDING)
                            ->reactive(),
                        
                        Select::make('verified_by')
                            ->relationship('verifiedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => in_array($get('verification_status'), [
                                WebsiteSubscription::VERIFICATION_VERIFIED,
                                WebsiteSubscription::VERIFICATION_REJECTED
                            ])),
                        
                        DateTimePicker::make('verified_at')
                            ->visible(fn (callable $get) => in_array($get('verification_status'), [
                                WebsiteSubscription::VERIFICATION_VERIFIED,
                                WebsiteSubscription::VERIFICATION_REJECTED
                            ])),
                        
                        Textarea::make('admin_notes')
                            ->placeholder('Add notes about verification status...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Payment Information')
                    ->schema([
                        TextInput::make('payment_method')
                            ->placeholder('e.g., bKash, Nagad, Bank Transfer')
                            ->maxLength(255),
                        
                        TextInput::make('transaction_id')
                            ->placeholder('Transaction/Reference ID')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('plan_type')
                    ->label('Plan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        WebsiteSubscription::PLAN_DAILY => 'Daily',
                        WebsiteSubscription::PLAN_WEEKLY => '15 Days',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        WebsiteSubscription::PLAN_DAILY => 'info',
                        WebsiteSubscription::PLAN_WEEKLY => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('BDT')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        WebsiteSubscription::STATUS_ACTIVE => 'success',
                        WebsiteSubscription::STATUS_EXPIRED => 'warning',
                        WebsiteSubscription::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    }),

                BadgeColumn::make('verification_status')
                    ->label('Verification')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        WebsiteSubscription::VERIFICATION_PENDING => 'Pending',
                        WebsiteSubscription::VERIFICATION_VERIFIED => 'Verified',
                        WebsiteSubscription::VERIFICATION_REJECTED => 'Rejected',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        WebsiteSubscription::VERIFICATION_PENDING => 'warning',
                        WebsiteSubscription::VERIFICATION_VERIFIED => 'success',
                        WebsiteSubscription::VERIFICATION_REJECTED => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('starts_at')
                    ->label('Starts At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('expires_at')
                    ->label('Expires At')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('verifiedBy.name')
                    ->label('Verified By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        WebsiteSubscription::STATUS_ACTIVE => 'Active',
                        WebsiteSubscription::STATUS_EXPIRED => 'Expired',
                        WebsiteSubscription::STATUS_CANCELLED => 'Cancelled',
                    ]),

                SelectFilter::make('verification_status')
                    ->label('Verification Status')
                    ->options([
                        WebsiteSubscription::VERIFICATION_PENDING => 'Pending',
                        WebsiteSubscription::VERIFICATION_VERIFIED => 'Verified',
                        WebsiteSubscription::VERIFICATION_REJECTED => 'Rejected',
                    ]),

                SelectFilter::make('plan_type')
                    ->label('Plan Type')
                    ->options([
                        WebsiteSubscription::PLAN_DAILY => 'Daily',
                        WebsiteSubscription::PLAN_WEEKLY => '15 Days',
                    ]),

                Filter::make('expires_soon')
                    ->label('Expires Soon (7 days)')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('expires_at', [now(), now()->addDays(7)])),

                Filter::make('expired')
                    ->label('Expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now())),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (WebsiteSubscription $record): bool => $record->isPending())
                    ->schema([
                        Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->placeholder('Add notes about verification...')
                            ->rows(3),
                    ])
                    ->action(function (WebsiteSubscription $record, array $data): void {
                        $record->verify(Auth::id(), $data['admin_notes'] ?? null);
                        
                        Notification::make()
                            ->title('Subscription verified successfully')
                            ->success()
                            ->send();
                    }),

                \Filament\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (WebsiteSubscription $record): bool => $record->isPending())
                    ->schema([
                        Textarea::make('admin_notes')
                            ->label('Rejection Reason')
                            ->placeholder('Please provide reason for rejection...')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (WebsiteSubscription $record, array $data): void {
                        $record->reject(Auth::id(), $data['admin_notes']);
                        
                        Notification::make()
                            ->title('Subscription rejected')
                            ->success()
                            ->send();
                    }),

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    
                    BulkAction::make('verify_selected')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->form([
                            Textarea::make('admin_notes')
                                ->label('Admin Notes')
                                ->placeholder('Add notes about verification...')
                                ->rows(3),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function (WebsiteSubscription $record) use ($data) {
                                if ($record->isPending()) {
                                    $record->verify(Auth::id(), $data['admin_notes'] ?? null);
                                }
                            });
                            
                            Notification::make()
                                ->title('Selected subscriptions verified successfully')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User'),
                        TextEntry::make('user.email')
                            ->label('Email'),
                        TextEntry::make('plan_type')
                            ->label('Plan')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                WebsiteSubscription::PLAN_DAILY => 'Daily Plan',
                                WebsiteSubscription::PLAN_WEEKLY => '15 Days Plan',
                                default => $state,
                            }),
                        TextEntry::make('amount')
                            ->label('Amount')
                            ->money('BDT'),
                        TextEntry::make('starts_at')
                            ->label('Starts At')
                            ->dateTime(),
                        TextEntry::make('expires_at')
                            ->label('Expires At')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Status & Verification')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                WebsiteSubscription::STATUS_ACTIVE => 'success',
                                WebsiteSubscription::STATUS_EXPIRED => 'warning',
                                WebsiteSubscription::STATUS_CANCELLED => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('verification_status')
                            ->label('Verification Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                WebsiteSubscription::VERIFICATION_PENDING => 'Pending',
                                WebsiteSubscription::VERIFICATION_VERIFIED => 'Verified',
                                WebsiteSubscription::VERIFICATION_REJECTED => 'Rejected',
                                default => $state,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                WebsiteSubscription::VERIFICATION_PENDING => 'warning',
                                WebsiteSubscription::VERIFICATION_VERIFIED => 'success',
                                WebsiteSubscription::VERIFICATION_REJECTED => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('verifiedBy.name')
                            ->label('Verified By')
                            ->visible(fn (?string $state): bool => filled($state)),
                        TextEntry::make('verified_at')
                            ->label('Verified At')
                            ->dateTime()
                            ->visible(fn (?string $state): bool => filled($state)),
                        TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->visible(fn (?string $state): bool => filled($state))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Payment Information')
                    ->schema([
                        TextEntry::make('payment_method')
                            ->label('Payment Method'),
                        TextEntry::make('transaction_id')
                            ->label('Transaction ID'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWebsiteSubscriptions::route('/'),
            'create' => CreateWebsiteSubscription::route('/create'),
            'view' => ViewWebsiteSubscription::route('/{record}'),
            'edit' => EditWebsiteSubscription::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('verification_status', WebsiteSubscription::VERIFICATION_PENDING)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : null;
    }
}