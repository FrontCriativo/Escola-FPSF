<?php

namespace App\Filament\Resources\ActiveSessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActiveSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('user.name')
                    ->label('Conta')
                    ->placeholder('-'),
                TextEntry::make('ip_address')
                    ->label('IP')
                    ->placeholder('-'),
                TextEntry::make('user_agent')
                    ->label('Dispositivo')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('payload')
                    ->label('Dados da sessao')
                    ->columnSpanFull(),
                TextEntry::make('last_activity')
                    ->label('Ultima atividade')
                    ->numeric(),
            ]);
    }
}
