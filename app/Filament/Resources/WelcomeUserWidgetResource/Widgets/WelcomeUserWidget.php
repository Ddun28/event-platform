<?php

namespace App\Filament\Resources\WelcomeUserWidgetResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;

class WelcomeUserWidget extends Widget
{
    protected static string $view = 'WelcomeUserWidgetResource.Widgets.welcome-user-widget'; 

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'user' => Auth::user()
        ];
    }

    public function getActions(): array
    {
        return [
            Action::make('logout')
                ->label('Cerrar sesión')
                ->icon('heroicon-o-arrow-left-on-rectangle')
                ->color('gray')
                ->action(fn () => auth()->logout())
        ];
    }
}