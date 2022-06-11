<?php

namespace SquadMS\Foundation\Filament\Pages;

use Filament\Pages\Page;

class RBAC extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static string $view = 'sqms-foundation::filament.pages.rbac';

    protected static ?string $title = 'RBAC';

    protected static ?string $slug = 'rbac';
}
