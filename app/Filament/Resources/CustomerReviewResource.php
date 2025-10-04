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
                            ->placeholder('Phone number being reviewed/reported')
                            ->helperText('The phone number that is being reviewed'),
                        Forms\Components\TextInput::make('commenter_phone')
                            ->label('Reviewer Phone')
                            ->tel()
                            ->required()
                            ->placeholder('Phone number of the person making the review')
                            ->helperText('The phone number of who is leaving this review'),
                        Forms\Components\TextInput::make('name')
                            ->label('Reviewer Name')
                            ->required()
                            ->placeholder('Name of the reviewer')
                            ->helperText('Full name of the person leaving the review'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Review Content')
                    ->schema([
                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star ⭐ (Report/Complaint)',
                                2 => '2 Stars ⭐⭐ (Poor)',
                                3 => '3 Stars ⭐⭐⭐ (Average)',
                                4 => '4 Stars ⭐⭐⭐⭐ (Good)',
                                5 => '5 Stars ⭐⭐⭐⭐⭐ (Excellent)',
                            ])
                            ->required()
                            ->helperText('1-2 stars are considered reports/complaints')
                            ->reactive(),
                        Forms\Components\Textarea::make('comment')
                            ->label('Review/Report Comment')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Detailed review description or report details')
                            ->helperText('Optional: Additional details about the experience'),
                    ])->columns(1),
                
                Forms\Components\Section::make('System Information')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Related Customer Record')
                            ->relationship('customer', 'phone')
                            ->searchable()
                            ->preload()
                            ->helperText('Link to existing customer search record if available')
                            ->placeholder('Search for customer record'),
                        Forms\Components\Placeholder::make('created_info')
                            ->label('Creation Info')
                            ->content(function ($record) {
                                if (!$record) return 'New review';
                                
                                return 'Created: ' . $record->created_at->format('M j, Y H:i') . ' (' . $record->created_at->diffForHumans() . ')';
                            }),
                        Forms\Components\Placeholder::make('review_type_info')
                            ->label('Review Type')
                            ->content(function ($record) {
                                if (!$record) return 'Will be determined by rating';
                                
                                return $record->review_type . ($record->isReport() ? ' 🚨' : ' ✅');
                            }),
                    ])->columns(3)->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->label('Target Phone')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->description('Phone number being reviewed'),
                Tables\Columns\TextColumn::make('commenter_phone')
                    ->label('Reviewer Phone')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->description('Phone number of reviewer'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Reviewer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(static function ($state): string {
                        return match (true) {
                            $state >= 4 => 'success',
                            $state == 3 => 'warning',
                            $state <= 2 => 'danger',
                            default => 'gray',
                        };
                    })
                    ->formatStateUsing(function ($state) {
                        return $state . ' ⭐';
                    }),
                Tables\Columns\TextColumn::make('review_type')
                    ->label('Type')
                    ->badge()
                    ->color(static function ($record): string {
                        return match (true) {
                            $record->rating >= 4 => 'success',
                            $record->rating == 3 => 'warning',
                            $record->rating <= 2 => 'danger',
                            default => 'gray',
                        };
                    }),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Review/Report Content')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(function ($record) {
                        return $record->comment ?: 'No comment provided';
                    })
                    ->placeholder('No comment'),
                Tables\Columns\TextColumn::make('customer_id')
                    ->label('Customer ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('customer.phone')
                    ->label('Customer Record')
                    ->searchable()
                    ->placeholder('No customer record')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '1 Star (Report)',
                        2 => '2 Stars (Poor)',
                        3 => '3 Stars (Average)',
                        4 => '4 Stars (Good)',
                        5 => '5 Stars (Excellent)',
                    ]),
                Tables\Filters\Filter::make('reports')
                    ->label('Reports & Complaints (1-2 Stars)')
                    ->query(fn (Builder $query): Builder => $query->where('rating', '<=', 2)),
                Tables\Filters\Filter::make('positive_reviews')
                    ->label('Positive Reviews (4-5 Stars)')
                    ->query(fn (Builder $query): Builder => $query->where('rating', '>=', 4)),
                Tables\Filters\Filter::make('recent_reviews')
                    ->label('Recent Reviews (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),
                Tables\Filters\Filter::make('has_comment')
                    ->label('Has Comment')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('comment')->where('comment', '!=', '')),
                Tables\Filters\Filter::make('same_phone')
                    ->label('Self Reviews (Same Phone)')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('phone', 'commenter_phone')),
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
