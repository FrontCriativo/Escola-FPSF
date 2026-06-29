<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use App\Filament\Resources\Books\Pages\Concerns\HandlesBookCoverUpload;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    use HandlesBookCoverUpload;

    protected static string $resource = BookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->normalizeBookData($data);
    }
}
