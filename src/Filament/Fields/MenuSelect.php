<?php

namespace SquadMS\Foundation\Filament\Fields;

use Filament\Forms\Components\Select;
use SquadMS\Foundation\Models\Menu;

class MenuSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(fn () => Menu::pluck('name', 'id'));
    }
}
