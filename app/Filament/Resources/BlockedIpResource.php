<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockedIpResource\Pages;
use App\Models\BlockedIp;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BlockedIpResource extends Resource
{
    protected static ?string $model = BlockedIp::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static string | \UnitEnum | null $navigationGroup = 'Security';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Blocked IPs';

    protected static ?string $pluralModelLabel = 'Blocked IPs';

    protected static ?string $modelLabel = 'Blocked IP';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('IP Block Details')
                    ->schema([
                        TextInput::make('ip_address')
                            ->required()
                            ->maxLength(45)
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g., 192.168.1.1')
                            ->helperText('Enter the IP address to block'),

                        Textarea::make('reason')
                            ->maxLength(255)
                            ->rows(3)
                            ->placeholder('Reason for blocking this IP')
                            ->helperText('Optional: Provide a reason for blocking'),

                        DateTimePicker::make('blocked_at')
                            ->required()
                            ->default(now())
                            ->label('Blocked At'),

                        DateTimePicker::make('expires_at')
                            ->nullable()
                            ->label('Expires At')
                            ->helperText('Leave empty for permanent block'),

                        Toggle::make('is_active')
                            ->default(true)
                            ->label('Active')
                            ->helperText('Toggle to enable/disable the block'),

                        Select::make('blocked_by')
                            ->relationship('blockedByUser', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())
                            ->label('Blocked By'),
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
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('IP copied!')
                    ->weight('bold'),

                TextColumn::make('reason')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->reason)
                    ->searchable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),

                TextColumn::make('status_label')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Permanently Blocked' => 'danger',
                        'Temporarily Blocked' => 'warning',
                        'Expired' => 'gray',
                        'Unblocked' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('blocked_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Permanent'),

                TextColumn::make('blockedByUser.name')
                    ->label('Blocked By')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active Blocks',
                        '0' => 'Inactive Blocks',
                    ])
                    ->label('Status'),

                Filter::make('permanent')
                    ->query(fn (Builder $query): Builder => $query->whereNull('expires_at'))
                    ->label('Permanent Blocks'),

                Filter::make('temporary')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('expires_at'))
                    ->label('Temporary Blocks'),

                Filter::make('expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now()))
                    ->label('Expired Blocks'),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('unblock')
                    ->label('Unblock')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Unblock IP Address')
                    ->modalDescription('Are you sure you want to unblock this IP address?')
                    ->action(fn (BlockedIp $record) => $record->update(['is_active' => false]))
                    ->visible(fn (BlockedIp $record) => $record->is_active),
                \Filament\Actions\Action::make('block')
                    ->label('Re-block')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Re-block IP Address')
                    ->modalDescription('Are you sure you want to re-block this IP address?')
                    ->action(fn (BlockedIp $record) => $record->update([
                        'is_active' => true,
                        'blocked_at' => Carbon::now('Asia/Dhaka'),
                        'expires_at' => null,
                    ]))
                    ->visible(fn (BlockedIp $record) => !$record->is_active),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('unblock_selected')
                        ->label('Unblock Selected')
                        ->icon('heroicon-o-lock-open')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('block_selected')
                        ->label('Block Selected')
                        ->icon('heroicon-o-lock-closed')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update([
                            'is_active' => true,
                            'blocked_at' => Carbon::now('Asia/Dhaka'),
                        ]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListBlockedIps::route('/'),
            'create' => Pages\CreateBlockedIp::route('/create'),
            'view' => Pages\ViewBlockedIp::route('/{record}'),
            'edit' => Pages\EditBlockedIp::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
