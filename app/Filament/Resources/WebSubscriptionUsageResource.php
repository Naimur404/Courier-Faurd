<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebSubscriptionUsageResource\Pages;
use App\Filament\Resources\WebSubscriptionUsageResource\Widgets;
use App\Models\WebSubscriptionUsage;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class WebSubscriptionUsageResource extends Resource
{
    protected static ?string $model = WebSubscriptionUsage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string | \UnitEnum | null $navigationGroup = 'Analytics';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Subscriber Usage';

    protected static ?string $pluralModelLabel = 'Subscriber Usage';

    protected static ?string $modelLabel = 'Usage Record';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Usage Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(),

                        Select::make('website_subscription_id')
                            ->relationship('subscription', 'id')
                            ->searchable()
                            ->preload()
                            ->disabled(),

                        TextInput::make('ip_address')
                            ->disabled(),

                        DatePicker::make('usage_date')
                            ->disabled(),

                        TextInput::make('hit_count')
                            ->numeric()
                            ->disabled(),

                        TextInput::make('endpoint')
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('subscription.plan_type')
                    ->label('Plan')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'daily' => 'info',
                        'weekly' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('usage_date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('hit_count')
                    ->label('Hits')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('Total'))
                    ->color(fn (int $state): string => match (true) {
                        $state >= 100 => 'danger',
                        $state >= 50 => 'warning',
                        default => 'success',
                    })
                    ->weight('bold'),

                TextColumn::make('ip_address')
                    ->label('Last IP')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('IP copied!')
                    ->toggleable(),

                TextColumn::make('last_hit_at')
                    ->label('Last Hit')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('usage_date', 'desc')
            ->filters([
                Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->where('usage_date', Carbon::now('Asia/Dhaka')->toDateString()))
                    ->label('Today')
                    ->default(),

                Filter::make('yesterday')
                    ->query(fn (Builder $query): Builder => $query->where('usage_date', Carbon::now('Asia/Dhaka')->subDay()->toDateString()))
                    ->label('Yesterday'),

                Filter::make('this_week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('usage_date', [
                        Carbon::now('Asia/Dhaka')->startOfWeek()->toDateString(),
                        Carbon::now('Asia/Dhaka')->endOfWeek()->toDateString(),
                    ]))
                    ->label('This Week'),

                Filter::make('this_month')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('usage_date', [
                        Carbon::now('Asia/Dhaka')->startOfMonth()->toDateString(),
                        Carbon::now('Asia/Dhaka')->endOfMonth()->toDateString(),
                    ]))
                    ->label('This Month'),

                Filter::make('high_usage')
                    ->query(fn (Builder $query): Builder => $query->where('hit_count', '>=', 50))
                    ->label('High Usage (50+)'),

                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by User'),

                Filter::make('date_range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('From'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->where('usage_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->where('usage_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'From ' . Carbon::parse($data['from'])->format('d M Y');
                        }
                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Until ' . Carbon::parse($data['until'])->format('d M Y');
                        }
                        return $indicators;
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('block_ip')
                    ->label('Block IP')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Block IP Address')
                    ->modalDescription(fn (WebSubscriptionUsage $record) => "Are you sure you want to block IP: {$record->ip_address}?")
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('reason')
                            ->label('Reason')
                            ->placeholder('Enter reason for blocking')
                            ->rows(2),
                    ])
                    ->action(function (WebSubscriptionUsage $record, array $data) {
                        \App\Models\BlockedIp::blockIp(
                            $record->ip_address,
                            $data['reason'] ?? 'Blocked from usage panel',
                            \Illuminate\Support\Facades\Auth::id()
                        );
                        
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('IP Blocked')
                            ->body("IP {$record->ip_address} has been blocked.")
                            ->send();
                    }),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('user.name')
                    ->label('User')
                    ->collapsible(),
                Tables\Grouping\Group::make('usage_date')
                    ->label('Date')
                    ->collapsible(),
            ])
            ->defaultSort('usage_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\UsageStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebSubscriptionUsages::route('/'),
            'view' => Pages\ViewWebSubscriptionUsage::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $todayHits = static::getModel()::where('usage_date', Carbon::now('Asia/Dhaka')->toDateString())->sum('hit_count');
        return $todayHits > 0 ? (string) $todayHits : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
