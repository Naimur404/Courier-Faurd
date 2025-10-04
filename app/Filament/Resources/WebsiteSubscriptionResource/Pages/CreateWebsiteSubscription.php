<?php

namespace App\Filament\Resources\WebsiteSubscriptionResource\Pages;

use App\Filament\Resources\WebsiteSubscriptionResource;
use Illuminate\Support\Facades\Auth;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\WebsiteSubscription;

class CreateWebsiteSubscription extends CreateRecord
{
    protected static string $resource = WebsiteSubscriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set verified_by and verified_at if verification status is set to verified
        if ($data['verification_status'] === WebsiteSubscription::VERIFICATION_VERIFIED) {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        } elseif ($data['verification_status'] === WebsiteSubscription::VERIFICATION_REJECTED) {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}