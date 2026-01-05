<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\BdCourierTokenResource\Pages\ListBdCourierTokens;
use App\Filament\Resources\BdCourierTokenResource\Pages\CreateBdCourierToken;
use App\Filament\Resources\BdCourierTokenResource\Pages\EditBdCourierToken;
use App\Filament\Resources\BdCourierTokenResource\Pages;
use App\Filament\Resources\BdCourierTokenResource\RelationManagers;
use App\Models\BdCourierToken;
use Filament\Forms;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationLabel = 'BD Courier Tokens';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Token Name')
                    ->placeholder('e.g., Token 1, Main Token')
                    ->maxLength(255),
                TextInput::make('token')
                    ->label('API Token')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter the BDCourier API token'),
                TextInput::make('priority')
                    ->label('Priority')
                    ->helperText('Lower number = higher priority (used first)')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
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
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('token')
                    ->label('Token')
                    ->limit(20)
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Token copied!'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('usage_count')
                    ->label('Uses Today')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cooldown_until')
                    ->label('Cooldown Until')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->isOnCooldown() ? 'danger' : 'success')
                    ->formatStateUsing(fn ($state, $record) => $record->isOnCooldown() 
                        ? Carbon::parse($state)->timezone('Asia/Dhaka')->format('M d, Y H:i') . ' BDT'
                        : 'Available'),
                TextColumn::make('last_used_at')
                    ->label('Last Used')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('priority', 'asc')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Filter::make('on_cooldown')
                    ->label('On Cooldown')
                    ->query(fn (Builder $query) => $query->whereNotNull('cooldown_until')->where('cooldown_until', '>', now())),
            ])
            ->recordActions([
                Action::make('clear_cooldown')
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('clear_all_cooldowns')
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
            'index' => ListBdCourierTokens::route('/'),
            'create' => CreateBdCourierToken::route('/create'),
            'edit' => EditBdCourierToken::route('/{record}/edit'),
        ];
    }
}
