<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use App\Support\AdminEmail;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table, bool $studentOnly = false): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('enrollment_number')->label('Matricula')->searchable()->toggleable(isToggledHiddenByDefault: ! $studentOnly),
                TextColumn::make('class_name')->label('Turma')->searchable()->toggleable(isToggledHiddenByDefault: ! $studentOnly),
                TextColumn::make('enrollment_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => User::enrollmentStatusOptions()[$state] ?? '-')
                    ->color(fn (?string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'transferred' => 'warning',
                        'graduated' => 'info',
                        default => 'gray',
                    })
                    ->visible($studentOnly),
                IconColumn::make('is_admin')->label('Admin')->boolean()->visible(! $studentOnly),
                TextColumn::make('loans_count')->label('Emprestimos')->counts('loans')->sortable(),
                TextColumn::make('created_at')->label('Criada em')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_admin')->label('Admins')->visible(! $studentOnly),
                SelectFilter::make('enrollment_status')
                    ->label('Status da matricula')
                    ->options(User::enrollmentStatusOptions())
                    ->visible($studentOnly),
                SelectFilter::make('class_name')
                    ->label('Turma')
                    ->options(fn () => User::query()->students()->whereNotNull('class_name')->distinct()->orderBy('class_name')->pluck('class_name', 'class_name'))
                    ->visible($studentOnly),
            ])
            ->recordActions([
                Action::make('sendEmail')
                    ->label($studentOnly ? 'Enviar email ao aluno' : 'Enviar email')
                    ->form(self::emailForm())
                    ->action(function (User $record, array $data): void {
                        $log = AdminEmail::send($record, $data['subject'], $data['body']);
                        $notification = Notification::make()
                            ->title($log->status === 'sent' ? 'Email enviado' : 'Falha ao enviar email')
                            ->body($log->status === 'sent' ? $record->email : $log->error);

                        $log->status === 'sent' ? $notification->success() : $notification->danger();
                        $notification->send();
                    }),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->hidden(fn (User $record): bool => auth()->id() === $record->id),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('sendBulkEmail')
                        ->label($studentOnly ? 'Enviar email aos alunos' : 'Enviar email')
                        ->form(self::emailForm())
                        ->action(function ($records, array $data): void {
                            $sent = 0;
                            $failed = 0;

                            $records->each(function (User $user) use ($data, &$sent, &$failed) {
                                $log = AdminEmail::send($user, $data['subject'], $data['body']);
                                $log->status === 'sent' ? $sent++ : $failed++;
                            });

                            Notification::make()
                                ->title('Envio concluido')
                                ->body("Enviados: {$sent}. Falhas: {$failed}.")
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function emailForm(): array
    {
        return [
            TextInput::make('subject')->label('Assunto')->required()->maxLength(255),
            Textarea::make('body')->label('Mensagem')->rows(8)->required(),
        ];
    }
}
