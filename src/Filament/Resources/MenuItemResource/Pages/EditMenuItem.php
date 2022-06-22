<?php

namespace SquadMS\Foundation\Filament\Resources\MenuItemResource\Pages;

use SquadMS\Foundation\Filament\Resources\MenuItemResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditMenuItem extends EditRecord
{
    use Translatable;
    
    protected static string $resource = MenuItemResource::class;
}
