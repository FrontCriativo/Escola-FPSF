<?php

namespace App\Filament\Widgets;

use App\Models\ActiveSession;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LibraryStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Livros cadastrados', Book::query()->count()),
            Stat::make('Exemplares disponiveis', Book::query()->sum('copies_available')),
            Stat::make('Emprestimos ativos', Loan::query()->whereIn('status', Loan::activeStatuses())->count()),
            Stat::make('Atrasados', Loan::query()->where('status', 'overdue')->count()),
            Stat::make('Alunos cadastrados', User::query()->students()->count()),
            Stat::make('Online agora', ActiveSession::query()->whereNotNull('user_id')->where('last_activity', '>=', now()->subMinutes(15)->timestamp)->count()),
        ];
    }
}
