<?php

namespace SquadMS\Foundation\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use SquadMS\Foundation\Facades\MenuManager;
use SquadMS\Foundation\Filament\Resources\Concerns\Translatable;
use SquadMS\Foundation\Filament\Resources\MenuItemResource\Pages;
use SquadMS\Foundation\Models\MenuItem;

class MenuItemResource extends Resource
{
    use Translatable;
    
    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\Select::make('type')
                ->options(MenuManager::generateSelectOptions())
                ->default('url')
                ->disablePlaceholderSelection()
                ->required()
                ->reactive(),
            Forms\Components\Group::make()
                ->schema(function (\Closure $get) {
                    if ($type = $get('type')) {
                        return MenuManager::getItemType($type)->actions();
                    }
                    return [];
                })
                ->statePath('content'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItem::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
