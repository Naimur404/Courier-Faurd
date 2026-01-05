<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use App\Filament\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-magnifying-glass';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Search Records';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Search Information')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->placeholder('01XXXXXXXXX'),
                        TextInput::make('count')
                            ->label('Search Count')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Number of times this number was searched'),
                        Select::make('search_by')
                            ->label('Search Source')
                            ->options([
                                'web' => 'Web Browser',
                                'app' => 'Mobile App',
                                'api' => 'API Request',
                            ])
                            ->required()
                            ->default('web'),
                    ])->columns(3),
                
                Section::make('Tracking Information')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('192.168.1.1'),
                        DateTimePicker::make('last_searched_at')
                            ->label('Last Searched')
                            ->displayFormat('Y-m-d H:i:s'),
                    ])->columns(2),
                
                Section::make('Search Data')
                    ->schema([
                        Textarea::make('data')
                            ->label('Raw Search Data (JSON)')
                            ->rows(15)
                            ->columnSpanFull()
                            ->helperText('Complete API response data in JSON format')
                            ->formatStateUsing(function ($state) {
                                if (is_array($state) || is_object($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }
                                return $state;
                            })
                            ->dehydrateStateUsing(function ($state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    return $decoded !== null ? $decoded : $state;
                                }
                                return $state;
                            }),
                    ]),
                
                Section::make('Courier Summary')
                    ->schema([
                        Placeholder::make('total_parcels')
                            ->label('Total Parcels')
                            ->content(fn (?Customer $record): string => $record ? number_format($record->total_parcels) : 'N/A'),
                        Placeholder::make('success_ratio')
                            ->label('Success Ratio')
                            ->content(fn (?Customer $record): string => $record ? $record->success_ratio . '%' : 'N/A'),
                        Placeholder::make('courier_services_count')
                            ->label('Courier Services')
                            ->content(fn (?Customer $record): string => $record ? count($record->courier_services) . ' services' : 'N/A'),
                    ])
                    ->columns(3)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Phone number copied!'),
                TextColumn::make('count')
                    ->label('Searches')
                    ->numeric()
                    ->sortable()
                    ->color('success')
                    ->badge(),
                BadgeColumn::make('search_by')
                    ->label('Source')
                    ->colors([
                        'primary' => 'web',
                        'success' => 'app',
                        'warning' => 'api',
                    ])
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('last_searched_at')
                    ->label('Last Search')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->since(),
                TextColumn::make('total_parcels')
                    ->label('Total Parcels')
                    ->getStateUsing(fn (Customer $record): string => number_format($record->total_parcels))
                    ->badge()
                    ->color('info')
                    ->sortable(false)
                    ->toggleable(),
                TextColumn::make('success_ratio')
                    ->label('Success Rate')
                    ->getStateUsing(fn (Customer $record): string => $record->success_ratio . '%')
                    ->badge()
                    ->color(static function (Customer $record): string {
                        return match (true) {
                            $record->success_ratio >= 90 => 'success',
                            $record->success_ratio >= 70 => 'warning',
                            default => 'danger',
                        };
                    })
                    ->sortable(false)
                    ->toggleable(),
                TextColumn::make('courier_services_count')
                    ->label('Courier Services')
                    ->getStateUsing(fn (Customer $record): string => count($record->courier_services) . ' services')
                    ->badge()
                    ->color('gray')
                    ->sortable(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('First Search')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('search_by')
                    ->label('Search Source')
                    ->options([
                        'web' => 'Web Browser',
                        'app' => 'Mobile App',
                        'api' => 'API Request',
                    ]),
                Filter::make('high_activity')
                    ->query(fn (Builder $query): Builder => $query->where('count', '>=', 10))
                    ->label('High Activity (10+ searches)'),
                Filter::make('recent')
                    ->query(fn (Builder $query): Builder => $query->where('last_searched_at', '>=', now()->subDays(7)))
                    ->label('Recent (Last 7 days)'),
                Filter::make('has_courier_data')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('data'))
                    ->label('Has Courier Data'),
                Filter::make('high_success_rate')
                    ->query(fn (Builder $query): Builder => $query->whereRaw("JSON_EXTRACT(data, '$.courierData.summary.success_ratio') >= 90"))
                    ->label('High Success Rate (90%+)'),
                Filter::make('many_parcels')
                    ->query(fn (Builder $query): Builder => $query->whereRaw("JSON_EXTRACT(data, '$.courierData.summary.total_parcel') >= 10"))
                    ->label('Many Parcels (10+)'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray'),
                ]),
            ])
            ->defaultSort('last_searched_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
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
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
