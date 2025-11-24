<?php

namespace App\Filament\Resources\SubscriptionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ApiKey;
use Filament\Notifications\Notification;

class ApiKeysRelationManager extends RelationManager
{
    protected static string $relationship = 'userApiKeys';
    
    protected static ?string $title = 'API Keys';
    
    protected static ?string $modelLabel = 'API Key';
    
    protected static ?string $pluralModelLabel = 'API Keys';
    
    public function getRelationshipQuery(): Builder
    {
        return ApiKey::query()->where('user_id', $this->getOwnerRecord()->user_id);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('API Key Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Key Name')
                            ->required()
                            ->placeholder('e.g., Production API Key')
                            ->maxLength(255),
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
                    ])
                    ->columns(3),
                Forms\Components\Section::make('Generated Keys')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('API Key')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Will be generated upon creation'),
                        Forms\Components\TextInput::make('secret')
                            ->label('API Secret')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Will be generated upon creation'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create'),
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
                    ])
                    ->columns(3)
                    ->hiddenOn('create'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Generate New API Key')
                    ->modalHeading('Generate New API Key')
                    ->createAnother(false)
                    ->using(function (array $data): ApiKey {
                        return ApiKey::create([
                            'user_id' => $this->getOwnerRecord()->user_id,
                            'name' => $data['name'],
                            'key' => ApiKey::generateKey(),
                            'secret' => ApiKey::generateSecret(),
                            'rate_limit' => $data['rate_limit'],
                            'is_active' => $data['is_active'],
                        ]);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('API Key Generated')
                            ->body('New API key has been created successfully.')
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('View API Key Details'),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit API Key'),
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (ApiKey $record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn (ApiKey $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (ApiKey $record) => $record->is_active ? 'danger' : 'success')
                    ->action(function (ApiKey $record) {
                        $record->update(['is_active' => !$record->is_active]);
                        
                        Notification::make()
                            ->title('API Key ' . ($record->is_active ? 'Activated' : 'Deactivated'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn (ApiKey $record) => ($record->is_active ? 'Deactivate' : 'Activate') . ' API Key')
                    ->modalDescription(fn (ApiKey $record) => 'Are you sure you want to ' . ($record->is_active ? 'deactivate' : 'activate') . ' this API key?'),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('API Key Deleted')
                            ->body('API key has been deleted successfully.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(fn (ApiKey $record) => $record->update(['is_active' => true]));
                            
                            Notification::make()
                                ->title('API Keys Activated')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(fn (ApiKey $record) => $record->update(['is_active' => false]));
                            
                            Notification::make()
                                ->title('API Keys Deactivated')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No API Keys')
            ->emptyStateDescription('This user doesn\'t have any API keys yet.')
            ->emptyStateIcon('heroicon-o-key')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Generate First API Key')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Generate New API Key')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Key Name')
                            ->required()
                            ->placeholder('e.g., Production API Key')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\TextInput::make('rate_limit')
                            ->label('Rate Limit (requests per minute)')
                            ->numeric()
                            ->default(60)
                            ->required()
                            ->minValue(1)
                            ->maxValue(1000),
                    ])
                    ->action(function (array $data) {
                        ApiKey::create([
                            'user_id' => $this->getOwnerRecord()->user_id,
                            'name' => $data['name'],
                            'key' => ApiKey::generateKey(),
                            'secret' => ApiKey::generateSecret(),
                            'rate_limit' => $data['rate_limit'],
                            'is_active' => $data['is_active'],
                        ]);
                        
                        Notification::make()
                            ->title('API Key Generated')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
