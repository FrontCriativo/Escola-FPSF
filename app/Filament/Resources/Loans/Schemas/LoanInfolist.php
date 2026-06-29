<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LoanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Aluno'),
                TextEntry::make('book.title')
                    ->label('Livro'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => \App\Models\Loan::statusOptions()[$state] ?? $state),
                TextEntry::make('borrowed_at')
                    ->label('Emprestado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
                TextEntry::make('due_at')
                    ->label('Devolver ate')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
                TextEntry::make('returned_at')
                    ->label('Devolvido em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->label('Observacoes')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
