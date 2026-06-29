<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema, bool $studentOnly = false): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Nome'),
                TextEntry::make('email')
                    ->label('Email'),
                TextEntry::make('phone')
                    ->label('Telefone')
                    ->placeholder('-'),
                TextEntry::make('enrollment_number')
                    ->label('Matricula')
                    ->placeholder('-')
                    ->visible($studentOnly),
                TextEntry::make('class_name')
                    ->label('Turma')
                    ->placeholder('-')
                    ->visible($studentOnly),
                TextEntry::make('enrollment_status')
                    ->label('Status da matricula')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'active' => 'Matriculado',
                        'inactive' => 'Inativo',
                        'transferred' => 'Transferido',
                        'graduated' => 'Concluido',
                        default => '-',
                    })
                    ->visible($studentOnly),
                TextEntry::make('enrollment_started_at')
                    ->label('Inicio da matricula')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->visible($studentOnly),
                IconEntry::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->visible(! $studentOnly),
                TextEntry::make('email_verified_at')
                    ->label('Email verificado em')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
