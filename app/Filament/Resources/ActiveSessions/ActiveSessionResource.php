<?php

namespace App\Filament\Resources\ActiveSessions;

use App\Filament\Resources\ActiveSessions\Pages\ListActiveSessions;
use App\Filament\Resources\ActiveSessions\Pages\ViewActiveSession;
use App\Filament\Resources\ActiveSessions\Schemas\ActiveSessionInfolist;
use App\Filament\Resources\ActiveSessions\Tables\ActiveSessionsTable;
use App\Models\ActiveSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Schema as SchemaFacade;
use UnitEnum;

class ActiveSessionResource extends Resource
{
    protected static ?string $model = ActiveSession::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Signal;
    protected static string|UnitEnum|null $navigationGroup = 'Pessoas';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'conta logada';
    protected static ?string $pluralModelLabel = 'contas logadas';

    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }

    public static function shouldRegisterNavigation(): bool
    {
        return SchemaFacade::hasTable('sessions');
    }

    public static function canViewAny(): bool
    {
        return SchemaFacade::hasTable('sessions');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! SchemaFacade::hasTable('sessions')) {
            return null;
        }

        return (string) ActiveSession::query()->whereNotNull('user_id')->where('last_activity', '>=', now()->subMinutes(15)->timestamp)->count();
    }

    public static function infolist(Schema $schema): Schema { return ActiveSessionInfolist::configure($schema); }
    public static function table(Table $table): Table { return ActiveSessionsTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListActiveSessions::route('/'),
            'view' => ViewActiveSession::route('/{record}'),
        ];
    }
}
