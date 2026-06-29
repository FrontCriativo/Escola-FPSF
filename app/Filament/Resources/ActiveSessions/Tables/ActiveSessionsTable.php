<?php

namespace App\Filament\Resources\ActiveSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ActiveSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('user')->whereNotNull('user_id')->latest('last_activity'))
            ->columns([
                IconColumn::make('is_online')->label('Online')->boolean(),
                TextColumn::make('user.name')->label('Conta')->searchable()->sortable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
                TextColumn::make('ip_address')->label('IP')->searchable(),
                TextColumn::make('last_seen_at')->label('Ultima atividade'),
                TextColumn::make('user_agent')->label('Dispositivo')->limit(80)->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('online')
                    ->label('Online agora')
                    ->queries(
                        true: fn ($query) => $query->where('last_activity', '>=', now()->subMinutes(15)->timestamp),
                        false: fn ($query) => $query->where('last_activity', '<', now()->subMinutes(15)->timestamp),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make()->label('Encerrar sessao')->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()->label('Encerrar sessoes')]),
            ]);
    }
}
