<?php

namespace SquadMS\Foundation\Filament\Resources;

use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Facades\SquadMSPermissions;
use SquadMS\Foundation\Filament\Resources\RBACResource\Pages;
use SquadMS\Foundation\Filament\Resources\RBACResource\RelationManagers;

class RBACResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'RBAC';

    protected static ?string $breadcrumb = 'RBAC';

    protected static ?string $pluralLabel = 'RBAC';

    protected static ?string $label = 'Role';

    protected static ?string $slug = 'rbac';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Role')->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()
            ])
            ->filters([
                //
            ])
            ->defaultSort('name');
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
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
