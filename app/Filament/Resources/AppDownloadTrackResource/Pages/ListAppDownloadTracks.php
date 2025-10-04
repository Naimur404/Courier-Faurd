<?php

namespace App\Filament\Resources\AppDownloadTrackResource\Pages;

use App\Filament\Resources\AppDownloadTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppDownloadTracks extends ListRecords
{
    protected static string $resource = AppDownloadTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
