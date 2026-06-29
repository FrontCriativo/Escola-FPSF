<?php

namespace App\Filament\Resources\Loans\Schemas;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            Select::make('user_id')
                ->label('Aluno')
                ->options(fn () => User::query()->students()->orderBy('name')->pluck('name', 'id'))
                ->searchable()
                ->required(),
            Select::make('book_id')
                ->label('Livro')
                ->options(fn () => Book::query()->orderBy('title')->pluck('title', 'id'))
                ->searchable()
                ->required(),
            Select::make('status')->label('Status')->options(Loan::statusOptions())->default('borrowed')->required()->live(),
            DateTimePicker::make('borrowed_at')->label('Emprestado em')->default(now())->required(),
            DateTimePicker::make('due_at')->label('Devolver ate')->default(now()->addDays(14))->required(),
            DateTimePicker::make('returned_at')->label('Devolvido em')->visible(fn ($get): bool => $get('status') === 'returned'),
            Textarea::make('notes')->label('Observacoes')->columnSpanFull(),
        ]);
    }
}
