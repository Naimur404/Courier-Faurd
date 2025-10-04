<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Subscription Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Plan Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly version of the plan name'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->step(0.01),
                        Forms\Components\Select::make('duration_months')
                            ->options([
                                1 => '1 Month',
                                3 => '3 Months',
                                6 => '6 Months',
                                12 => '12 Months',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('request_limit')
                            ->required()
                            ->numeric()
                            ->helperText('Daily API request limit'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Order in which plans appear (lower numbers first)'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Plan Content')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->maxLength(500)
                            ->helperText('Short description of the plan'),
                        Forms\Components\TagsInput::make('features')
                            ->helperText('List of plan features'),
                    ]),
                
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Whether this plan is available for purchase'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('BDT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_months')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => match($state) {
                        1 => '1 Month',
                        3 => '3 Months',
                        6 => '6 Months',
                        12 => '1 Year',
                        default => "{$state} Months"
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_limit')
                    ->label('Daily Limit')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Subscriptions')
                    ->counts('subscriptions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Active Plans')
                    ->falseLabel('Inactive Plans')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
