<?php

namespace App\Filament\Resources\WebsitePlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class WebsitePlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('৳')
                                    ->minValue(0),
                                TextInput::make('duration_days')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('days'),
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
                Section::make('Appearance')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('icon')
                                    ->placeholder('e.g., Zap, Crown, Star')
                                    ->helperText('Lucide icon name'),
                                Select::make('color')
                                    ->options([
                                        'indigo' => 'Indigo',
                                        'purple' => 'Purple',
                                        'blue' => 'Blue',
                                        'green' => 'Green',
                                        'yellow' => 'Yellow',
                                        'orange' => 'Orange',
                                        'red' => 'Red',
                                        'pink' => 'Pink',
                                    ])
                                    ->default('indigo'),
                            ]),
                        TagsInput::make('features')
                            ->placeholder('Add feature')
                            ->helperText('Press Enter to add each feature'),
                    ]),
                Section::make('Status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                                Toggle::make('is_popular')
                                    ->label('Mark as Popular'),
                            ]),
                    ]),
            ]);
    }
}
