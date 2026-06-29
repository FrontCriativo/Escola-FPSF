<?php

namespace App\Filament\Resources\EmailLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmailLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sender.name')
                    ->label('Enviado por')
                    ->placeholder('-'),
                TextEntry::make('recipient.name')
                    ->label('Destinatario')
                    ->placeholder('-'),
                TextEntry::make('recipient_email')->label('Email do destinatario'),
                TextEntry::make('subject')->label('Assunto'),
                TextEntry::make('body')
                    ->label('Mensagem')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'sent' ? 'Enviado' : 'Falhou'),
                TextEntry::make('error')
                    ->label('Erro')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sent_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
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
