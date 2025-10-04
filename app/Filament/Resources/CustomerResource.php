<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    
    protected static ?string $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Search Records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Search Information')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->placeholder('01XXXXXXXXX'),
                        Forms\Components\TextInput::make('count')
                            ->label('Search Count')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Number of times this number was searched'),
                        Forms\Components\Select::make('search_by')
                            ->label('Search Source')
                            ->options([
                                'web' => 'Web Browser',
                                'app' => 'Mobile App',
                                'api' => 'API Request',
                            ])
                            ->required()
                            ->default('web'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Tracking Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('192.168.1.1'),
                        Forms\Components\DateTimePicker::make('last_searched_at')
                            ->label('Last Searched')
                            ->displayFormat('Y-m-d H:i:s'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Search Data')
                    ->schema([
                        Forms\Components\Textarea::make('data')
                            ->label('Raw Search Data (JSON)')
                            ->rows(10)
                            ->columnSpanFull()
                            ->helperText('Complete API response data in JSON format'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Phone number copied!'),
                Tables\Columns\TextColumn::make('count')
                    ->label('Searches')
                    ->numeric()
                    ->sortable()
                    ->color('success')
                    ->badge(),
                Tables\Columns\BadgeColumn::make('search_by')
                    ->label('Source')
                    ->colors([
                        'primary' => 'web',
                        'success' => 'app',
                        'warning' => 'api',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_searched_at')
                    ->label('Last Search')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('First Search')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('search_by')
                    ->label('Search Source')
                    ->options([
                        'web' => 'Web Browser',
                        'app' => 'Mobile App',
                        'api' => 'API Request',
                    ]),
                Tables\Filters\Filter::make('high_activity')
                    ->query(fn (Builder $query): Builder => $query->where('count', '>=', 10))
                    ->label('High Activity (10+ searches)'),
                Tables\Filters\Filter::make('recent')
                    ->query(fn (Builder $query): Builder => $query->where('last_searched_at', '>=', now()->subDays(7)))
                    ->label('Recent (Last 7 days)'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
