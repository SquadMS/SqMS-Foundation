<?php

namespace SquadMS\Foundation\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use SquadMS\Foundation\Filament\Resources\MenuResource\Pages;
use SquadMS\Foundation\Filament\Resources\MenuResource\RelationManagers;
use SquadMS\Foundation\Models\Menu;

class MenuResource extends Resource
{
    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Placeholder::make('updated_at')
                    ->content(fn (?Menu $record) => $record ? $record->updated_at->format(config('tables.date_time_format')) : '-'),
                Forms\Components\Placeholder::make('created_at')
                    ->content(fn (?Menu $record) => $record ? $record->created_at->format(config('tables.date_time_format')) : '-')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('name');
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\MenuMenuItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenu::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
