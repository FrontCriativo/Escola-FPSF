<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema, bool $studentOnly = false): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('name')->label('Nome')->required()->maxLength(255),
            TextInput::make('email')->label('Email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
            TextInput::make('phone')->label('Telefone')->tel()->maxLength(255),
            TextInput::make('password')
                ->label('Senha')
                ->password()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn ($state): bool => filled($state))
                ->maxLength(255),
            TextInput::make('enrollment_number')
                ->label('Matricula')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->hidden(fn ($get): bool => ! $studentOnly && (bool) $get('is_admin')),
            TextInput::make('class_name')
                ->label('Turma')
                ->maxLength(255)
                ->hidden(fn ($get): bool => ! $studentOnly && (bool) $get('is_admin')),
            Select::make('enrollment_status')
                ->label('Status da matricula')
                ->options(User::enrollmentStatusOptions())
                ->default('active')
                ->required(fn ($get): bool => $studentOnly || ! (bool) $get('is_admin'))
                ->hidden(fn ($get): bool => ! $studentOnly && (bool) $get('is_admin')),
            DatePicker::make('enrollment_started_at')
                ->label('Inicio da matricula')
                ->native(false)
                ->hidden(fn ($get): bool => ! $studentOnly && (bool) $get('is_admin')),
            DateTimePicker::make('email_verified_at')->label('Email verificado em')->default(now()),
            Toggle::make('is_admin')
                ->label('Admin')
                ->default(false)
                ->live()
                ->hidden($studentOnly),
            Hidden::make('is_admin')
                ->default(false)
                ->visible($studentOnly),
        ]);
    }
}
