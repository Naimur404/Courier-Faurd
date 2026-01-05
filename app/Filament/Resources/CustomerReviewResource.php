<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CustomerReviewResource\Pages\ListCustomerReviews;
use App\Filament\Resources\CustomerReviewResource\Pages\CreateCustomerReview;
use App\Filament\Resources\CustomerReviewResource\Pages\EditCustomerReview;
use App\Filament\Resources\CustomerReviewResource\Pages;
use App\Filament\Resources\CustomerReviewResource\RelationManagers;
use App\Models\CustomerReview;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerReviewResource extends Resource
{
    protected static ?string $model = CustomerReview::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Reviews & Reports';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review Information')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Target Phone Number')
                            ->tel()
                            ->required()
                            ->placeholder('Phone number being reviewed/reported')
                            ->helperText('The phone number that is being reviewed'),
                        TextInput::make('commenter_phone')
                            ->label('Reviewer Phone')
                            ->tel()
                            ->required()
                            ->placeholder('Phone number of the person making the review')
                            ->helperText('The phone number of who is leaving this review'),
                        TextInput::make('name')
                            ->label('Reviewer Name')
                            ->required()
                            ->placeholder('Name of the reviewer')
                            ->helperText('Full name of the person leaving the review'),
                    ])->columns(3),
                
                Section::make('Review Content')
                    ->schema([
                        Select::make('rating')
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
                        Textarea::make('comment')
                            ->label('Review/Report Comment')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Detailed review description or report details')
                            ->helperText('Optional: Additional details about the experience'),
                    ])->columns(1),
                
                Section::make('System Information')
                    ->schema([
                        Select::make('customer_id')
                            ->label('Related Customer Record')
                            ->relationship('customer', 'phone')
                            ->searchable()
                            ->preload()
                            ->helperText('Link to existing customer search record if available')
                            ->placeholder('Search for customer record'),
                        Placeholder::make('created_info')
                            ->label('Creation Info')
                            ->content(function ($record) {
                                if (!$record) return 'New review';
                                
                                return 'Created: ' . $record->created_at->format('M j, Y H:i') . ' (' . $record->created_at->diffForHumans() . ')';
                            }),
                        Placeholder::make('review_type_info')
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
                TextColumn::make('phone')
                    ->label('Target Phone')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->description('Phone number being reviewed'),
                TextColumn::make('commenter_phone')
                    ->label('Reviewer Phone')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->description('Phone number of reviewer'),
                TextColumn::make('name')
                    ->label('Reviewer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('rating')
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
                TextColumn::make('review_type')
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
                TextColumn::make('comment')
                    ->label('Review/Report Content')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(function ($record) {
                        return $record->comment ?: 'No comment provided';
                    })
                    ->placeholder('No comment'),
                TextColumn::make('customer_id')
                    ->label('Customer ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('customer.phone')
                    ->label('Customer Record')
                    ->searchable()
                    ->placeholder('No customer record')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '1 Star (Report)',
                        2 => '2 Stars (Poor)',
                        3 => '3 Stars (Average)',
                        4 => '4 Stars (Good)',
                        5 => '5 Stars (Excellent)',
                    ]),
                Filter::make('reports')
                    ->label('Reports & Complaints (1-2 Stars)')
                    ->query(fn (Builder $query): Builder => $query->where('rating', '<=', 2)),
                Filter::make('positive_reviews')
                    ->label('Positive Reviews (4-5 Stars)')
                    ->query(fn (Builder $query): Builder => $query->where('rating', '>=', 4)),
                Filter::make('recent_reviews')
                    ->label('Recent Reviews (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7))),
                Filter::make('has_comment')
                    ->label('Has Comment')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('comment')->where('comment', '!=', '')),
                Filter::make('same_phone')
                    ->label('Self Reviews (Same Phone)')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('phone', 'commenter_phone')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListCustomerReviews::route('/'),
            'create' => CreateCustomerReview::route('/create'),
            'edit' => EditCustomerReview::route('/{record}/edit'),
        ];
    }
}
