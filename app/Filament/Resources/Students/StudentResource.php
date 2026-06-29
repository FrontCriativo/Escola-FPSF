<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Pages\ViewStudent;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;
    protected static string|UnitEnum|null $navigationGroup = 'Pessoas';
    protected static ?int $navigationSort = 0;
    protected static ?string $modelLabel = 'aluno';
    protected static ?string $pluralModelLabel = 'alunos';
    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->students();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) User::query()->enrolled()->count();
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema, studentOnly: true);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema, studentOnly: true);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table, studentOnly: true);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'view' => ViewStudent::route('/{record}'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
