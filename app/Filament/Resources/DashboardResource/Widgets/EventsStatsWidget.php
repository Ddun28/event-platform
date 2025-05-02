<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Category;
use App\Models\Event;
use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Eventos', Event::count())
                ->icon('heroicon-o-calendar')
                ->color('primary')
                ->chart([7, 2, 5, 12, 8]) // Opcional: Datos para gráfico
                ->description('Eventos registrados'),

            Stat::make('Categorías Activas', Category::count())
                ->icon('heroicon-o-tag')
                ->color('success')
                ->description('Diferentes categorías'),

            Stat::make('Etiquetas Disponibles', Tag::count())
                ->icon('heroicon-o-hashtag')
                ->color('warning')
                ->description('Total de etiquetas'),
        ];
    }
    
    // Opcional: Para tamaño completo
    public function getColumnSpan(): int|string|array
{
    return [
        'md' => 2,
        'xl' => 3,
    ];
}
}