<?php

namespace App\Filament\Resources\WebsiteSubscriptionResource\Pages;

use App\Filament\Resources\WebsiteSubscriptionResource;
use Illuminate\Support\Facades\Auth;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\WebsiteSubscription;

class EditWebsiteSubscription extends EditRecord
{
    protected static string $resource = WebsiteSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $originalData = $this->record->getOriginal();
        
        // If verification status changed to verified or rejected, set verified_by and verified_at
        if ($data['verification_status'] !== $originalData['verification_status']) {
            if (in_array($data['verification_status'], [
                WebsiteSubscription::VERIFICATION_VERIFIED,
                WebsiteSubscription::VERIFICATION_REJECTED
            ])) {
                $data['verified_by'] = Auth::id();
                $data['verified_at'] = now();
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}