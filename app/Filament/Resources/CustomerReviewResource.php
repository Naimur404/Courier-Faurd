<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerReviewResource\Pages;
use App\Filament\Resources\CustomerReviewResource\RelationManagers;
use App\Models\CustomerReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerReviewResource extends Resource
{
    protected static ?string $model = CustomerReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Reviews & Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Information')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Target Phone Number')
                            ->tel()
                            ->required()
                            ->placeholder('Phone number being reviewed'),
                        Forms\Components\TextInput::make('commenter_phone')
                            ->label('Reviewer Phone')
                            ->tel()
                            ->required()
                            ->placeholder('Phone number of reviewer'),
                        Forms\Components\TextInput::make('name')
                            ->label('Reviewer Name')
                            ->required()
                            ->placeholder('Name of the reviewer'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Review Content')
                    ->schema([
                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star (Report/Complaint)',
                                2 => '2 Stars (Poor)',
                                3 => '3 Stars (Average)',
                                4 => '4 Stars (Good)',
                                5 => '5 Stars (Excellent)',
                            ])
                            ->required()
                            ->helperText('Rating of 1 is considered a report/complaint'),
                        Forms\Components\Textarea::make('comment')
                            ->label('Review Comment')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Detailed review or report description'),
                    ])->columns(1),
                
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_id')
                            ->label('Customer ID')
                            ->numeric()
                            ->disabled()
                            ->helperText('Auto-generated from customer records'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('courier_name')
                    ->label('Courier Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('courier_rating')
                    ->label('Courier Rating')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(static function ($state): string {
                        return match (true) {
                            $state >= 4 => 'success',
                            $state >= 3 => 'warning',
                            default => 'danger',
                        };
                    }),
                Tables\Columns\TextColumn::make('customer_rating')
                    ->label('Customer Rating')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(static function ($state): string {
                        return match (true) {
                            $state >= 4 => 'success',
                            $state >= 3 => 'warning',
                            default => 'danger',
                        };
                    }),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Customer Phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('courier_phone')
                    ->label('Courier Phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('customer_address')
                    ->label('Customer Address')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('courier_address')
                    ->label('Courier Address')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('review_content')
                    ->label('Review Content')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->review_content;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('courier_rating')
                    ->label('Courier Rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ]),
                Tables\Filters\SelectFilter::make('customer_rating')
                    ->label('Customer Rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ]),
                Tables\Filters\Filter::make('recent_reviews')
                    ->label('Recent Reviews (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCustomerReviews::route('/'),
            'create' => Pages\CreateCustomerReview::route('/create'),
            'edit' => Pages\EditCustomerReview::route('/{record}/edit'),
        ];
    }
}
