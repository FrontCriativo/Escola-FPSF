<?php

namespace App\Filament\Resources\Loans;

use App\Filament\Resources\Loans\Pages\CreateLoan;
use App\Filament\Resources\Loans\Pages\EditLoan;
use App\Filament\Resources\Loans\Pages\ListLoans;
use App\Filament\Resources\Loans\Pages\ViewLoan;
use App\Filament\Resources\Loans\Schemas\LoanForm;
use App\Filament\Resources\Loans\Schemas\LoanInfolist;
use App\Filament\Resources\Loans\Tables\LoansTable;
use App\Models\Loan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowsRightLeft;
    protected static string|UnitEnum|null $navigationGroup = 'Operacao';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'emprestimo';
    protected static ?string $pluralModelLabel = 'emprestimos';

    public static function getNavigationBadge(): ?string
    {
        return (string) Loan::query()->whereIn('status', Loan::activeStatuses())->count();
    }

    public static function form(Schema $schema): Schema { return LoanForm::configure($schema); }
    public static function infolist(Schema $schema): Schema { return LoanInfolist::configure($schema); }
    public static function table(Table $table): Table { return LoansTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'create' => CreateLoan::route('/create'),
            'view' => ViewLoan::route('/{record}'),
            'edit' => EditLoan::route('/{record}/edit'),
        ];
    }
}
