<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->label('Categoria')
                    ->placeholder('-'),
                TextEntry::make('title')->label('Titulo'),
                TextEntry::make('author')->label('Autor'),
                TextEntry::make('isbn')
                    ->label('ISBN')
                    ->placeholder('-'),
                TextEntry::make('publisher')
                    ->label('Editora')
                    ->placeholder('-'),
                TextEntry::make('publication_year')
                    ->label('Ano')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pages')
                    ->label('Paginas')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label('Descricao')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cover_path')
                    ->label('Capa')
                    ->placeholder('-'),
                TextEntry::make('accent_color')->label('Cor do card'),
                TextEntry::make('shelf_location')
                    ->label('Estante')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => \App\Models\Book::statusOptions()[$state] ?? $state),
                TextEntry::make('copies_total')
                    ->label('Exemplares totais')
                    ->numeric(),
                TextEntry::make('copies_available')
                    ->label('Exemplares disponiveis')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
