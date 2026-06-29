<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()->hidden(fn (): bool => auth()->id() === $this->record->id),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
