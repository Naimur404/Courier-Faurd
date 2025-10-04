<?php

namespace App\Filament\Resources\AppDownloadTrackResource\Pages;

use App\Filament\Resources\AppDownloadTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppDownloadTrack extends EditRecord
{
    protected static string $resource = AppDownloadTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
