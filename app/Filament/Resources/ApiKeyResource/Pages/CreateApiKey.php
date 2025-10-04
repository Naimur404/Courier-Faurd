<?php

namespace App\Filament\Resources\ApiKeyResource\Pages;

use App\Filament\Resources\ApiKeyResource;
use App\Models\ApiKey;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApiKey extends CreateRecord
{
    protected static string $resource = ApiKeyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate key and secret automatically
        $data['key'] = ApiKey::generateKey();
        $data['secret'] = ApiKey::generateSecret();
        
        // Set default rate limit if not provided
        if (!isset($data['rate_limit']) || empty($data['rate_limit'])) {
            $data['rate_limit'] = 60; // Default 60 requests per minute
        }
        
        // Initialize usage count
        $data['usage_count'] = 0;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
