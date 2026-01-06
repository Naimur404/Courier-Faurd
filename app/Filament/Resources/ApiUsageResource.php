<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ApiUsageResource\Pages\ListApiUsages;
use App\Filament\Resources\ApiUsageResource\Pages;
use App\Filament\Resources\ApiUsageResource\RelationManagers;
use App\Models\ApiUsage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiUsageResource extends Resource
{
    protected static ?string $model = ApiUsage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static string | \UnitEnum | null $navigationGroup = 'API Management';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'API Usage Logs';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Request Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('api_key_id')
                            ->label('API Key')
                            ->relationship('apiKey', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('endpoint')
                            ->label('API Endpoint')
                            ->required(),
                        Select::make('method')
                            ->label('HTTP Method')
                            ->options([
                                'GET' => 'GET',
                                'POST' => 'POST',
                                'PUT' => 'PUT',
                                'PATCH' => 'PATCH',
                                'DELETE' => 'DELETE',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
                    
                Section::make('Request Details')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required(),
                        TextInput::make('user_agent')
                            ->label('User Agent')
                            ->columnSpanFull(),
                        Textarea::make('request_data')
                            ->label('Request Data (JSON)')
                            ->columnSpanFull()
                            ->rows(6)
                            ->formatStateUsing(function ($state) {
                                if (is_array($state) || is_object($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    if ($decoded !== null) {
                                        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }
                                }
                                return $state;
                            }),
                    ])
                    ->columns(2),
                    
                Section::make('Response Information')
                    ->schema([
                        TextInput::make('response_code')
                            ->label('Response Status')
                            ->numeric()
                            ->required(),
                        TextInput::make('response_time')
                            ->label('Response Time (ms)')
                            ->numeric()
                            ->required(),
                        Textarea::make('response_data')
                            ->label('Response Data (JSON)')
                            ->columnSpanFull()
                            ->rows(10)
                            ->formatStateUsing(function ($state) {
                                if (is_array($state) || is_object($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    if ($decoded !== null) {
                                        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }
                                }
                                return $state;
                            }),
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
                    ->weight('medium'),
                TextColumn::make('endpoint')
                    ->label('Endpoint')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        return $record->endpoint;
                    }),
                TextColumn::make('method')
                    ->label('Method')
                    ->badge()
                    ->color(static function ($state): string {
                        return match ($state) {
                            'GET' => 'info',
                            'POST' => 'success',
                            'PUT', 'PATCH' => 'warning',
                            'DELETE' => 'danger',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('response_code')
                    ->label('Status')
                    ->badge()
                    ->color(static function ($state): string {
                        return match (true) {
                            $state >= 200 && $state < 300 => 'success',
                            $state >= 300 && $state < 400 => 'info',
                            $state >= 400 && $state < 500 => 'warning',
                            $state >= 500 => 'danger',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('response_time')
                    ->label('Response Time')
                    ->getStateUsing(function ($record) {
                        if ($record->response_time < 1000) {
                            return $record->response_time . 'ms';
                        }
                        return number_format($record->response_time / 1000, 2) . 's';
                    })
                    ->sortable()
                    ->color(static function ($record): string {
                        return match (true) {
                            $record->response_time < 200 => 'success',
                            $record->response_time < 1000 => 'warning',
                            default => 'danger',
                        };
                    }),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Request Time')
                    ->dateTime('M j, Y H:i:s')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->label('HTTP Method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                        'PUT' => 'PUT',
                        'PATCH' => 'PATCH',
                        'DELETE' => 'DELETE',
                    ]),
                SelectFilter::make('response_code')
                    ->label('Response Status')
                    ->options([
                        '200' => '200 - OK',
                        '201' => '201 - Created',
                        '400' => '400 - Bad Request',
                        '401' => '401 - Unauthorized',
                        '403' => '403 - Forbidden',
                        '404' => '404 - Not Found',
                        '422' => '422 - Unprocessable Entity',
                        '429' => '429 - Too Many Requests',
                        '500' => '500 - Internal Server Error',
                    ]),
                Filter::make('successful_requests')
                    ->label('Successful Requests')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('response_code', [200, 299])),
                Filter::make('failed_requests')
                    ->label('Failed Requests')
                    ->query(fn (Builder $query): Builder => $query->where('response_code', '>=', 400)),
                Filter::make('slow_requests')
                    ->label('Slow Requests (>1s)')
                    ->query(fn (Builder $query): Builder => $query->where('response_time', '>', 1000)),
                Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
                Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds for real-time monitoring
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
            'index' => ListApiUsages::route('/'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('created_at', today())->count();
    }
}
