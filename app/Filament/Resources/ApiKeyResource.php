<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyResource\Pages;
use App\Filament\Resources\ApiKeyResource\RelationManagers;
use App\Models\ApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiKeyResource extends Resource
{
    protected static ?string $model = ApiKey::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationGroup = 'API Management';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'API Keys';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('API Key Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Key Name')
                            ->required()
                            ->placeholder('e.g., Production API Key'),
                        Forms\Components\TextInput::make('key')
                            ->label('API Key')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Generated automatically')
                            ->helperText('API key is generated automatically when creating a new key'),
                        Forms\Components\TextInput::make('secret')
                            ->label('API Secret')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Generated automatically')
                            ->helperText('API secret is generated automatically when creating a new key'),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Settings & Limits')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to enable/disable this API key'),
                        Forms\Components\TextInput::make('rate_limit')
                            ->label('Rate Limit (requests per minute)')
                            ->numeric()
                            ->default(60)
                            ->required()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->helperText('Maximum number of requests per minute'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->nullable()
                            ->helperText('Leave empty for no expiration'),
                    ])
                    ->columns(3),
                    
                Forms\Components\Section::make('Usage Statistics')
                    ->schema([
                        Forms\Components\Placeholder::make('usage_count')
                            ->label('Total Usage')
                            ->content(fn (?ApiKey $record): string => $record ? number_format($record->usage_count) . ' requests' : '0 requests'),
                        Forms\Components\Placeholder::make('today_usage')
                            ->label('Today\'s Usage')
                            ->content(fn (?ApiKey $record): string => $record ? number_format($record->getTodayUsageCount()) . ' requests' : '0 requests'),
                        Forms\Components\Placeholder::make('last_used_at')
                            ->label('Last Used')
                            ->content(fn (?ApiKey $record): string => $record && $record->last_used_at ? $record->last_used_at->diffForHumans() : 'Never'),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created')
                            ->content(fn (?ApiKey $record): string => $record ? $record->created_at->format('M j, Y H:i') : 'N/A'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create'),

                Forms\Components\Section::make('API Documentation')
                    ->schema([
                        Forms\Components\Placeholder::make('api_docs_link')
                            ->label('API Documentation')
                            ->content(fn (): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString(
                                '<div class="space-y-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Learn how to use your API key:</p>
                                    <a href="' . url('/api/documentation') . '" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View API Documentation
                                    </a>
                                </div>'
                            )),
                    ])
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Key Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('key')
                    ->label('API Key')
                    ->limit(20)
                    ->copyable()
                    ->tooltip(function ($record) {
                        return $record->key;
                    })
                    ->formatStateUsing(function ($state) {
                        return substr($state, 0, 8) . '...' . substr($state, -8);
                    }),
                Tables\Columns\TextColumn::make('secret')
                    ->label('API Secret')
                    ->limit(20)
                    ->copyable()
                    ->tooltip(function ($record) {
                        return $record->secret;
                    })
                    ->formatStateUsing(function ($state) {
                        return substr($state, 0, 8) . '...' . substr($state, -8);
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('rate_limit')
                    ->label('Rate Limit')
                    ->suffix(' /min')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Usage Count')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
                Tables\Columns\TextColumn::make('last_used_at')
                    ->label('Last Used')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->placeholder('Never')
                    ->description(function ($record) {
                        return $record->last_used_at ? $record->last_used_at->diffForHumans() : null;
                    }),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->placeholder('Never')
                    ->color(function ($record) {
                        if (!$record->expires_at) return null;
                        
                        $daysUntilExpiry = now()->diffInDays($record->expires_at, false);
                        return match (true) {
                            $daysUntilExpiry < 0 => 'danger',
                            $daysUntilExpiry < 7 => 'warning',
                            default => null,
                        };
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All Keys')
                    ->trueLabel('Active Keys')
                    ->falseLabel('Inactive Keys'),
                Tables\Filters\Filter::make('expired')
                    ->label('Expired Keys')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now())),
                Tables\Filters\Filter::make('expiring_soon')
                    ->label('Expiring Soon (7 days)')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('expires_at', [now(), now()->addDays(7)])),
                Tables\Filters\Filter::make('high_usage')
                    ->label('High Usage (>1000 requests)')
                    ->query(fn (Builder $query): Builder => $query->where('usage_count', '>', 1000)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (ApiKey $record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn (ApiKey $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (ApiKey $record) => $record->is_active ? 'danger' : 'success')
                    ->action(function (ApiKey $record) {
                        $record->update(['is_active' => !$record->is_active]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn (ApiKey $record) => ($record->is_active ? 'Deactivate' : 'Activate') . ' API Key')
                    ->modalDescription(fn (ApiKey $record) => 'Are you sure you want to ' . ($record->is_active ? 'deactivate' : 'activate') . ' this API key?'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(fn (ApiKey $record) => $record->update(['is_active' => true]));
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(fn (ApiKey $record) => $record->update(['is_active' => false]));
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListApiKeys::route('/'),
            'create' => Pages\CreateApiKey::route('/create'),
            'edit' => Pages\EditApiKey::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }
}
