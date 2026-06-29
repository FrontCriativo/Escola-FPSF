<?php

namespace App\Filament\Resources\EmailLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmailLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['sender', 'recipient'])->latest('sent_at'))
            ->columns([
                TextColumn::make('recipient_email')->label('Destinatario')->searchable(),
                TextColumn::make('subject')->label('Assunto')->searchable()->limit(50),
                TextColumn::make('sender.name')->label('Enviado por')->placeholder('Sistema'),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => $state === 'sent' ? 'success' : 'danger')->formatStateUsing(fn (string $state): string => $state === 'sent' ? 'Enviado' : 'Falhou'),
                TextColumn::make('sent_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(['sent' => 'Enviado', 'failed' => 'Falhou']),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
