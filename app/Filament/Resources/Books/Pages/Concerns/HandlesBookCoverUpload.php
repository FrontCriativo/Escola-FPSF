<?php

namespace App\Filament\Resources\Books\Pages\Concerns;

trait HandlesBookCoverUpload
{
    protected function normalizeBookData(array $data): array
    {
        if (! empty($data['uploaded_cover'])) {
            $data['cover_path'] = $data['uploaded_cover'];
        }

        unset($data['uploaded_cover']);

        return $data;
    }
}
