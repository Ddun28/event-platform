<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios Registrados', User::count())
                ->icon('heroicon-o-user-group')
                ->color('danger')
                ->description('Total de usuarios en el sistema')
                ->chart([7, 2, 5, 12, 8]),
        ];
    }
}