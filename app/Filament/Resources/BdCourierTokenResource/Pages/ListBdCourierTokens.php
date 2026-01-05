<?php

namespace App\Filament\Resources\BdCourierTokenResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\BdCourierTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBdCourierTokens extends ListRecords
{
    protected static string $resource = BdCourierTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
