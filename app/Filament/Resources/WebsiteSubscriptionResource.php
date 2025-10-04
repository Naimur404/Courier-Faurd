<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebsiteSubscriptionResource\Pages;
use App\Models\WebsiteSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;

class WebsiteSubscriptionResource extends Resource
{
    protected static ?string $model = WebsiteSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Website Subscriptions';

    protected static ?string $pluralModelLabel = 'Website Subscriptions';

    protected static ?string $modelLabel = 'Website Subscription';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subscription Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\Select::make('plan_type')
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
                        
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('৳')
                            ->required()
                            ->step(0.01),
                        
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->required()
                            ->default(now()),
                        
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Verification')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                WebsiteSubscription::STATUS_ACTIVE => 'Active',
                                WebsiteSubscription::STATUS_EXPIRED => 'Expired',
                                WebsiteSubscription::STATUS_CANCELLED => 'Cancelled',
                            ])
                            ->required()
                            ->default(WebsiteSubscription::STATUS_ACTIVE),
                        
                        Forms\Components\Select::make('verification_status')
                            ->options([
                                WebsiteSubscription::VERIFICATION_PENDING => 'Pending Verification',
                                WebsiteSubscription::VERIFICATION_VERIFIED => 'Verified',
                                WebsiteSubscription::VERIFICATION_REJECTED => 'Rejected',
                            ])
                            ->required()
                            ->default(WebsiteSubscription::VERIFICATION_PENDING)
                            ->reactive(),
                        
                        Forms\Components\Select::make('verified_by')
                            ->relationship('verifiedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (callable $get) => in_array($get('verification_status'), [
                                WebsiteSubscription::VERIFICATION_VERIFIED,
                                WebsiteSubscription::VERIFICATION_REJECTED
                            ])),
                        
                        Forms\Components\DateTimePicker::make('verified_at')
                            ->visible(fn (callable $get) => in_array($get('verification_status'), [
                                WebsiteSubscription::VERIFICATION_VERIFIED,
                                WebsiteSubscription::VERIFICATION_REJECTED
                            ])),
                        
                        Forms\Components\Textarea::make('admin_notes')
                            ->placeholder('Add notes about verification status...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('payment_method')
                            ->placeholder('e.g., bKash, Nagad, Bank Transfer')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('transaction_id')
                            ->placeholder('Transaction/Reference ID')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('plan_type')
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

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('BDT')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        WebsiteSubscription::STATUS_ACTIVE => 'success',
                        WebsiteSubscription::STATUS_EXPIRED => 'warning',
                        WebsiteSubscription::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\BadgeColumn::make('verification_status')
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

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Starts At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('verifiedBy.name')
                    ->label('Verified By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
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

                Tables\Filters\Filter::make('expires_soon')
                    ->label('Expires Soon (7 days)')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('expires_at', [now(), now()->addDays(7)])),

                Tables\Filters\Filter::make('expired')
                    ->label('Expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now())),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (WebsiteSubscription $record): bool => $record->isPending())
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
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

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (WebsiteSubscription $record): bool => $record->isPending())
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
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

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('verify_selected')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->form([
                            Forms\Components\Textarea::make('admin_notes')
                                ->label('Admin Notes')
                                ->placeholder('Add notes about verification...')
                                ->rows(3),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Subscription Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('User'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('plan_type')
                            ->label('Plan')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                WebsiteSubscription::PLAN_DAILY => 'Daily Plan',
                                WebsiteSubscription::PLAN_WEEKLY => '15 Days Plan',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('amount')
                            ->label('Amount')
                            ->money('BDT'),
                        Infolists\Components\TextEntry::make('starts_at')
                            ->label('Starts At')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('expires_at')
                            ->label('Expires At')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Status & Verification')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                WebsiteSubscription::STATUS_ACTIVE => 'success',
                                WebsiteSubscription::STATUS_EXPIRED => 'warning',
                                WebsiteSubscription::STATUS_CANCELLED => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('verification_status')
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
                        Infolists\Components\TextEntry::make('verifiedBy.name')
                            ->label('Verified By')
                            ->visible(fn (?string $state): bool => filled($state)),
                        Infolists\Components\TextEntry::make('verified_at')
                            ->label('Verified At')
                            ->dateTime()
                            ->visible(fn (?string $state): bool => filled($state)),
                        Infolists\Components\TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->visible(fn (?string $state): bool => filled($state))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Payment Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Payment Method'),
                        Infolists\Components\TextEntry::make('transaction_id')
                            ->label('Transaction ID'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])
                    ->columns(2)
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
            'index' => Pages\ListWebsiteSubscriptions::route('/'),
            'create' => Pages\CreateWebsiteSubscription::route('/create'),
            'view' => Pages\ViewWebsiteSubscription::route('/{record}'),
            'edit' => Pages\EditWebsiteSubscription::route('/{record}/edit'),
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