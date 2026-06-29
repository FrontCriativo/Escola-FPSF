<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('name')->columns([
            TextColumn::make('name')->label('Nome')->searchable()->sortable(),
            TextColumn::make('slug')->searchable()->toggleable(),
            ColorColumn::make('color')->label('Cor'),
            TextColumn::make('books_count')->label('Livros')->counts('books')->sortable(),
            TextColumn::make('updated_at')->label('Atualizado')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            TernaryFilter::make('has_books')
                ->label('Com livros')
                ->queries(
                    true: fn ($query) => $query->has('books'),
                    false: fn ($query) => $query->doesntHave('books'),
                    blank: fn ($query) => $query,
                ),
        ])->recordActions([
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
