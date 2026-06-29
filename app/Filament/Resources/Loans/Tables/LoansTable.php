<?php

namespace App\Filament\Resources\Loans\Tables;

use App\Models\Loan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['user', 'book'])->latest('borrowed_at'))
            ->columns([
                TextColumn::make('user.name')->label('Conta')->searchable()->sortable(),
                TextColumn::make('book.title')->label('Livro')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn (string $state): string => Loan::statusOptions()[$state] ?? $state)->color(fn (string $state): string => match ($state) {
                    'borrowed' => 'info',
                    'returned' => 'success',
                    'overdue' => 'warning',
                    'lost' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('borrowed_at')->label('Emprestado')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('due_at')->label('Devolver ate')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('returned_at')->label('Devolvido')->dateTime('d/m/Y H:i')->placeholder('-')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(Loan::statusOptions()),
                SelectFilter::make('user_id')->label('Aluno')->relationship('user', 'name')->searchable()->preload(),
                SelectFilter::make('book_id')->label('Livro')->relationship('book', 'title')->searchable()->preload(),
            ])
            ->recordActions([
                Action::make('returnBook')
                    ->label('Devolver')
                    ->visible(fn (Loan $record): bool => $record->status !== 'returned')
                    ->requiresConfirmation()
                    ->action(function (Loan $record): void {
                        $record->updateManaged(['status' => 'returned', 'returned_at' => now()]);
                        Notification::make()->title('Livro devolvido')->success()->send();
                    }),
                Action::make('markOverdue')
                    ->label('Marcar atraso')
                    ->visible(fn (Loan $record): bool => $record->status === 'borrowed')
                    ->action(function (Loan $record): void {
                        $record->updateManaged(['status' => 'overdue']);
                        Notification::make()->title('Emprestimo marcado como atrasado')->warning()->send();
                    }),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
