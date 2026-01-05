<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BdCourierTokenResource\Pages;
use App\Filament\Resources\BdCourierTokenResource\RelationManagers;
use App\Models\BdCourierToken;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;

class BdCourierTokenResource extends Resource
{
    protected static ?string $model = BdCourierToken::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationLabel = 'API Tokens';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Token Name')
                    ->placeholder('e.g., Token 1, Main Token')
                    ->maxLength(255),
                Forms\Components\TextInput::make('token')
                    ->label('API Token')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter the BDCourier API token'),
                Forms\Components\TextInput::make('priority')
                    ->label('Priority')
                    ->helperText('Lower number = higher priority (used first)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->helperText('Inactive tokens will not be used')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('token')
                    ->label('Token')
                    ->limit(20)
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Token copied!'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Priority')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Uses Today')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cooldown_until')
                    ->label('Cooldown Until')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->isOnCooldown() ? 'danger' : 'success')
                    ->formatStateUsing(fn ($state, $record) => $record->isOnCooldown() 
                        ? Carbon::parse($state)->timezone('Asia/Dhaka')->format('M d, Y H:i') . ' BDT'
                        : 'Available'),
                Tables\Columns\TextColumn::make('last_used_at')
                    ->label('Last Used')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('priority', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\Filter::make('on_cooldown')
                    ->label('On Cooldown')
                    ->query(fn (Builder $query) => $query->whereNotNull('cooldown_until')->where('cooldown_until', '>', now())),
            ])
            ->actions([
                Tables\Actions\Action::make('clear_cooldown')
                    ->label('Clear Cooldown')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->visible(fn ($record) => $record->isOnCooldown())
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->clearCooldown();
                        Notification::make()
                            ->title('Cooldown cleared')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('clear_all_cooldowns')
                        ->label('Clear All Cooldowns')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->clearCooldown();
                            }
                            Notification::make()
                                ->title('Cooldowns cleared for selected tokens')
                                ->success()
                                ->send();
                        }),
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
            'index' => Pages\ListBdCourierTokens::route('/'),
            'create' => Pages\CreateBdCourierToken::route('/create'),
            'edit' => Pages\EditBdCourierToken::route('/{record}/edit'),
        ];
    }
}
