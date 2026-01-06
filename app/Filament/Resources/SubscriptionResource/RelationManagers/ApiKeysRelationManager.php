<?php

namespace App\Filament\Resources\SubscriptionResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('API Key Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Key Name')
                            ->required()
                            ->placeholder('e.g., Production API Key')
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to enable/disable this API key'),
                        TextInput::make('rate_limit')
                            ->label('Rate Limit (requests per minute)')
                            ->numeric()
                            ->default(60)
                            ->required()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->helperText('Maximum number of requests per minute'),
                    ])
                    ->columns(3),
                Section::make('Generated Keys')
                    ->description('Click on the key/secret to copy to clipboard')
                    ->schema([
                        TextInput::make('key')
                            ->label('API Key')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => $record?->key)
                            ->extraAttributes(['class' => 'font-mono text-sm'])
                            ->suffixAction(
                                \Filament\Forms\Components\Actions\Action::make('copyKey')
                                    ->icon('heroicon-o-clipboard-document')
                                    ->action(function ($state, $livewire) {
                                        $livewire->dispatch('copy-to-clipboard', text: $state);
                                        Notification::make()
                                            ->title('API Key copied!')
                                            ->success()
                                            ->duration(2000)
                                            ->send();
                                    })
                            ),
                        TextInput::make('secret')
                            ->label('API Secret')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn ($record) => $record?->secret)
                            ->extraAttributes(['class' => 'font-mono text-sm'])
                            ->suffixAction(
                                \Filament\Forms\Components\Actions\Action::make('copySecret')
                                    ->icon('heroicon-o-clipboard-document')
                                    ->action(function ($state, $livewire) {
                                        $livewire->dispatch('copy-to-clipboard', text: $state);
                                        Notification::make()
                                            ->title('API Secret copied!')
                                            ->success()
                                            ->duration(2000)
                                            ->send();
                                    })
                            ),
                    ])
                    ->columns(2)
                    ->hiddenOn('create'),
                Section::make('Usage Statistics')
                    ->schema([
                        Placeholder::make('usage_count')
                            ->label('Total Usage')
                            ->content(function ($get, $record, $livewire): string {
                                if (!$record) return '0 requests';
                                // Refresh the usage count to get latest data
                                $record->refreshUsageCount();
                                return number_format($record->usage_count) . ' requests';
                            }),
                        Placeholder::make('today_usage')
                            ->label('Today\'s Usage')
                            ->content(function ($get, $record): string {
                                if (!$record) return '0 requests';
                                $todayCount = $record->getTodayUsageCount();
                                return number_format($todayCount) . ' requests';
                            }),
                        Placeholder::make('monthly_usage')
                            ->label('Monthly Usage')
                            ->content(function ($get, $record): string {
                                if (!$record) return '0 requests';
                                $monthlyCount = $record->getMonthlyUsageCount();
                                return number_format($monthlyCount) . ' requests';
                            }),
                        Placeholder::make('last_used_at')
                            ->label('Last Used')
                            ->content(function ($get, $record): string {
                                if (!$record || !$record->last_used_at) return 'Never';
                                return $record->last_used_at->diffForHumans();
                            }),
                    ])
                    ->columns(4)
                    ->hiddenOn('create'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Key Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('key')
                    ->label('API Key')
                    ->limit(20)
                    ->copyable()
                    ->tooltip(function ($record) {
                        return $record->key;
                    })
                    ->formatStateUsing(function ($state) {
                        return substr($state, 0, 8) . '...' . substr($state, -8);
                    }),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('rate_limit')
                    ->label('Rate Limit')
                    ->suffix(' /min')
                    ->sortable(),
                TextColumn::make('usage_count')
                    ->label('Total Usage')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        // Refresh the count to get latest data
                        $record->refreshUsageCount();
                        return number_format($record->usage_count) . ' requests';
                    }),
                TextColumn::make('today_usage')
                    ->label('Today\'s Usage')
                    ->getStateUsing(function ($record) {
                        return $record->getTodayUsageCount();
                    })
                    ->formatStateUsing(fn ($state) => number_format($state) . ' requests')
                    ->sortable(),
                TextColumn::make('last_used_at')
                    ->label('Last Used')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->placeholder('Never')
                    ->description(function ($record) {
                        return $record->last_used_at ? $record->last_used_at->diffForHumans() : null;
                    }),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All Keys')
                    ->trueLabel('Active Keys')
                    ->falseLabel('Inactive Keys'),
            ])
            ->headerActions([
                CreateAction::make()
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
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('View API Key Details'),
                EditAction::make()
                    ->modalHeading('Edit API Key'),
                Action::make('toggle_status')
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
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('API Key Deleted')
                            ->body('API key has been deleted successfully.')
                    ),
                Action::make('debug_usage')
                    ->label('Debug Usage')
                    ->icon('heroicon-o-bug-ant')
                    ->color('info')
                    ->action(function (ApiKey $record) {
                        $totalUsages = $record->apiUsages()->count();
                        $todayUsages = $record->apiUsages()->whereDate('created_at', today())->count();
                        $monthlyUsages = $record->apiUsages()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
                        $storedCount = $record->usage_count;
                        $lastUsed = $record->last_used_at ? $record->last_used_at->format('Y-m-d H:i:s') : 'Never';
                        
                        Notification::make()
                            ->title('Usage Debug Info')
                            ->body("API Key: {$record->name}\nAPI Usages in DB: {$totalUsages}\nToday: {$todayUsages}\nMonthly: {$monthlyUsages}\nStored Count: {$storedCount}\nLast Used: {$lastUsed}")
                            ->info()
                            ->persistent()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
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
                    BulkAction::make('deactivate')
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
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No API Keys')
            ->emptyStateDescription('This user doesn\'t have any API keys yet.')
            ->emptyStateIcon('heroicon-o-key')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Generate First API Key')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Generate New API Key')
                    ->schema([
                        TextInput::make('name')
                            ->label('Key Name')
                            ->required()
                            ->placeholder('e.g., Production API Key')
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('rate_limit')
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
