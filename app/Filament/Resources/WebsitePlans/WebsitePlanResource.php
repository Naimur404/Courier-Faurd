<?php

namespace App\Filament\Resources\WebsitePlans;

use App\Filament\Resources\WebsitePlans\Pages\CreateWebsitePlan;
use App\Filament\Resources\WebsitePlans\Pages\EditWebsitePlan;
use App\Filament\Resources\WebsitePlans\Pages\ListWebsitePlans;
use App\Filament\Resources\WebsitePlans\Schemas\WebsitePlanForm;
use App\Filament\Resources\WebsitePlans\Tables\WebsitePlansTable;
use App\Models\WebsitePlan;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WebsitePlanResource extends Resource
{
    protected static ?string $model = WebsitePlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|UnitEnum|null $navigationGroup = 'Subscriptions';

    protected static ?string $navigationLabel = 'Website Plans';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return WebsitePlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WebsitePlansTable::configure($table);
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
            'index' => ListWebsitePlans::route('/'),
            'create' => CreateWebsitePlan::route('/create'),
            'edit' => EditWebsitePlan::route('/{record}/edit'),
        ];
    }
}
