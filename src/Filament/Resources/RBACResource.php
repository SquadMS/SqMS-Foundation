<?php

namespace SquadMS\Foundation\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Filament\Resources\RBACResource\Pages;

class RBACResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $title = 'RBAC';

    protected static ?string $slug = 'rbac';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRBAC::route('/'),
            'create' => Pages\CreateRBAC::route('/create'),
            'edit' => Pages\EditRBAC::route('/{record}/edit'),
        ];
    }
}
