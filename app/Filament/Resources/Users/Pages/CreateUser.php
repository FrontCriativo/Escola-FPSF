<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->normalizeUserData($data);
    }

    private function normalizeUserData(array $data): array
    {
        if ((bool) ($data['is_admin'] ?? false)) {
            $data['enrollment_number'] = null;
            $data['class_name'] = null;
            $data['enrollment_status'] = null;
            $data['enrollment_started_at'] = null;
        }

        return $data;
    }
}
