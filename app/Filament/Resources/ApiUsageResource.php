<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiUsageResource\Pages;
use App\Filament\Resources\ApiUsageResource\RelationManagers;
use App\Models\ApiUsage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiUsageResource extends Resource
{
    protected static ?string $model = ApiUsage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static ?string $navigationGroup = 'API Management';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'API Usage Logs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Request Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('api_key_id')
                            ->label('API Key')
                            ->relationship('apiKey', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('endpoint')
                            ->label('API Endpoint')
                            ->required(),
                        Forms\Components\Select::make('method')
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
                    
                Forms\Components\Section::make('Request Details')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required(),
                        Forms\Components\TextInput::make('user_agent')
                            ->label('User Agent')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('request_data')
                            ->label('Request Data (JSON)')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Response Information')
                    ->schema([
                        Forms\Components\TextInput::make('response_status')
                            ->label('Response Status')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('response_time')
                            ->label('Response Time (ms)')
                            ->numeric()
                            ->required(),
                        Forms\Components\Textarea::make('response_data')
                            ->label('Response Data (JSON)')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),
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
                Tables\Columns\TextColumn::make('endpoint')
                    ->label('Endpoint')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        return $record->endpoint;
                    }),
                Tables\Columns\TextColumn::make('method')
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
                Tables\Columns\TextColumn::make('response_status')
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
                Tables\Columns\TextColumn::make('response_time')
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
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Request Time')
                    ->dateTime('M j, Y H:i:s')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->label('HTTP Method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                        'PUT' => 'PUT',
                        'PATCH' => 'PATCH',
                        'DELETE' => 'DELETE',
                    ]),
                Tables\Filters\SelectFilter::make('response_status')
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
                Tables\Filters\Filter::make('successful_requests')
                    ->label('Successful Requests')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('response_status', [200, 299])),
                Tables\Filters\Filter::make('failed_requests')
                    ->label('Failed Requests')
                    ->query(fn (Builder $query): Builder => $query->where('response_status', '>=', 400)),
                Tables\Filters\Filter::make('slow_requests')
                    ->label('Slow Requests (>1s)')
                    ->query(fn (Builder $query): Builder => $query->where('response_time', '>', 1000)),
                Tables\Filters\Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
                Tables\Filters\Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListApiUsages::route('/'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('created_at', today())->count();
    }
}
