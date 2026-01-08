<?php

namespace App\Filament\Resources\WebsitePlans\Pages;

use App\Filament\Resources\WebsitePlans\WebsitePlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWebsitePlan extends EditRecord
{
    protected static string $resource = WebsitePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
