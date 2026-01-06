<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;
use Exception;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\AppDownloadTrackResource\Pages\ListAppDownloadTracks;
use App\Filament\Resources\AppDownloadTrackResource\Pages\CreateAppDownloadTrack;
use App\Filament\Resources\AppDownloadTrackResource\Pages\EditAppDownloadTrack;
use App\Filament\Resources\AppDownloadTrackResource\Pages;
use App\Filament\Resources\AppDownloadTrackResource\RelationManagers;
use App\Models\AppDownloadTrack;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppDownloadTrackResource extends Resource
{
    protected static ?string $model = AppDownloadTrack::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-down-on-square';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationLabel = 'App Downloads';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Download Information')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required()
                            ->placeholder('192.168.1.1'),
                        Select::make('status')
                            ->label('Download Status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'complete' => 'Complete',
                                'failed' => 'Failed',
                            ])
                            ->default('complete')
                            ->required(),
                        DateTimePicker::make('completed_at')
                            ->label('Completed At')
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable(),
                TextColumn::make('status')
                    ->label('Download Status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(static function ($state): string {
                        return match ($state) {
                            'complete' => 'success',
                            'in_progress' => 'warning',
                            'pending' => 'info',
                            'failed' => 'danger',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('created_at')
                    ->label('Download Started')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
                TextColumn::make('completed_at')
                    ->label('Completed At')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->placeholder('Not completed')
                    ->description(function ($record) {
                        if (!$record->completed_at) {
                            return null;
                        }
                        
                        try {
                            // Ensure completed_at is a Carbon instance
                            $completedAt = $record->completed_at instanceof Carbon 
                                ? $record->completed_at 
                                : Carbon::parse($record->completed_at);
                            return $completedAt->diffForHumans();
                        } catch (Exception $e) {
                            return null;
                        }
                    }),
                TextColumn::make('formatted_duration')
                    ->label('Duration')
                    ->sortable(false)
                    ->getStateUsing(function ($record) {
                        return $record->formatted_duration;
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Download Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'complete' => 'Complete',
                        'failed' => 'Failed',
                    ]),
                Filter::make('recent_downloads')
                    ->label('Recent Downloads (Last 24 hours)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDay())),
                Filter::make('failed_downloads')
                    ->label('Failed Downloads')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'failed')),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => ListAppDownloadTracks::route('/'),
            'create' => CreateAppDownloadTrack::route('/create'),
            'edit' => EditAppDownloadTrack::route('/{record}/edit'),
        ];
    }
}
