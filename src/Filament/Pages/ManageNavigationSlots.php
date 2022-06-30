<?php

namespace SquadMS\Foundation\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Pages\SettingsPage;
use RyanChandler\FilamentNavigation\Filament\Fields\NavigationSelect;
use SquadMS\Foundation\Facades\SquadMSThemeManager;
use SquadMS\Foundation\Themes\Settings\ThemesNavigationsSettings;

class ManageNavigationSlots extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Design';

    protected static ?string $title = 'Navigation Slots';

    protected static string $settings = ThemesNavigationsSettings::class;

    protected function getFormSchema(): array
    {
        return [
            //            TextInput::make('test')->required(),
            Repeater::make('slotHandles')
                ->disableItemMovement()
                ->schema([
                    Select::make('slot')
                        ->options(SquadMSThemeManager::getMenuSlots())
                        ->required(),
                    NavigationSelect::make('navigation')
                        ->required(),
                ]),
        ];
    }
}
