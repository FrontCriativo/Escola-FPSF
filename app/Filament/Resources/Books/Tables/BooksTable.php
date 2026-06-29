<?php

namespace App\Filament\Resources\Books\Tables;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('category'))
            ->defaultSort('title')
            ->columns([
                TextColumn::make('title')->label('Titulo')->searchable()->sortable(),
                TextColumn::make('author')->label('Autor')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Categoria')->badge()->searchable()->sortable(),
                TextColumn::make('copies_available')->label('Disponiveis')->numeric()->sortable(),
                TextColumn::make('copies_total')->label('Total')->numeric()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn (string $state): string => Book::statusOptions()[$state] ?? $state)->color(fn (string $state): string => match ($state) {
                    'available' => 'success',
                    'reserved' => 'warning',
                    'maintenance' => 'gray',
                    default => 'gray',
                }),
                IconColumn::make('is_featured')->label('Home')->boolean(),
                TextColumn::make('shelf_location')->label('Estante')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Atualizado')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')->label('Categoria')->relationship('category', 'name'),
                SelectFilter::make('status')->label('Status')->options(Book::statusOptions()),
                TernaryFilter::make('is_featured')->label('Destacado'),
            ])
            ->recordActions([
                Action::make('loan')
                    ->label('Emprestar')
                    ->visible(fn (Book $record): bool => $record->is_available)
                    ->form([
                        Select::make('user_id')->label('Aluno')->options(fn () => User::query()->students()->orderBy('name')->pluck('name', 'id'))->searchable()->required(),
                        DateTimePicker::make('due_at')->label('Data de devolucao')->default(now()->addDays(14))->required(),
                        Textarea::make('notes')->label('Observacoes'),
                    ])
                    ->action(function (Book $record, array $data): void {
                        Loan::createManaged([
                            'user_id' => $data['user_id'],
                            'book_id' => $record->id,
                            'status' => 'borrowed',
                            'due_at' => $data['due_at'],
                            'notes' => $data['notes'] ?? null,
                        ]);

                        Notification::make()->title('Emprestimo registrado')->success()->send();
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
