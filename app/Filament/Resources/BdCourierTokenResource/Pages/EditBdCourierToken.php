<?php

namespace App\Filament\Resources\BdCourierTokenResource\Pages;

use App\Filament\Resources\BdCourierTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBdCourierToken extends EditRecord
{
    protected static string $resource = BdCourierTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
