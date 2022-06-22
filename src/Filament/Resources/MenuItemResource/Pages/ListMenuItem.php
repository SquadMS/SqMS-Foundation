<?php

namespace SquadMS\Foundation\Filament\Resources\MenuItemResource\Pages;

use SquadMS\Foundation\Filament\Resources\MenuItemResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListMenuItem extends ListRecords
{
    use Translatable;
    
    protected static string $resource = MenuItemResource::class;
}
