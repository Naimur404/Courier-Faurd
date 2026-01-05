<?php

namespace App\Filament\Resources\ApiUsageResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ApiUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiUsage extends EditRecord
{
    protected static string $resource = ApiUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
