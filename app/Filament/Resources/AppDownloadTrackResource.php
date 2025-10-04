<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppDownloadTrackResource\Pages;
use App\Filament\Resources\AppDownloadTrackResource\RelationManagers;
use App\Models\AppDownloadTrack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppDownloadTrackResource extends Resource
{
    protected static ?string $model = AppDownloadTrack::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-on-square';
    
    protected static ?string $navigationGroup = 'Search Data';
    
    protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationLabel = 'App Downloads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Download Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->required()
                            ->placeholder('192.168.1.1'),
                        Forms\Components\Select::make('status')
                            ->label('Download Status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'complete' => 'Complete',
                                'failed' => 'Failed',
                            ])
                            ->default('complete')
                            ->required(),
                        Forms\Components\DateTimePicker::make('completed_at')
                            ->label('Completed At')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable(),
                Tables\Columns\TextColumn::make('status')
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Download Started')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->description(function ($record) {
                        return $record->created_at->diffForHumans();
                    }),
                Tables\Columns\TextColumn::make('completed_at')
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
                            $completedAt = $record->completed_at instanceof \Carbon\Carbon 
                                ? $record->completed_at 
                                : \Carbon\Carbon::parse($record->completed_at);
                            return $completedAt->diffForHumans();
                        } catch (\Exception $e) {
                            return null;
                        }
                    }),
                Tables\Columns\TextColumn::make('formatted_duration')
                    ->label('Duration')
                    ->sortable(false)
                    ->getStateUsing(function ($record) {
                        return $record->formatted_duration;
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Download Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'complete' => 'Complete',
                        'failed' => 'Failed',
                    ]),
                Tables\Filters\Filter::make('recent_downloads')
                    ->label('Recent Downloads (Last 24 hours)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDay())),
                Tables\Filters\Filter::make('failed_downloads')
                    ->label('Failed Downloads')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'failed')),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListAppDownloadTracks::route('/'),
            'create' => Pages\CreateAppDownloadTrack::route('/create'),
            'edit' => Pages\EditAppDownloadTrack::route('/{record}/edit'),
        ];
    }
}
