<?php

namespace SquadMS\Foundation\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use SquadMS\Foundation\Models\MenuMenuItem;

class MenuMenuItemsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'menuMenuItems';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('menu_item_id')
                ->relationship('menuItem', 'name')
                ->required(),
            Forms\Components\Select::make('parent_id')
                ->relationship('parent', 'id')#
                ->nullable()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->getStateUsing(fn (MenuMenuItem $record) => $record->menuItem->name),
                Tables\Columns\TextColumn::make('parent_id')
                    ->label('Parent')
                    ->getStateUsing(fn (MenuMenuItem $record) => $record->parent ? $record->parent->menuItem->name : '-'),
                Tables\Columns\TextColumn::make('order')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('order_up')
                    ->iconButton()
                    ->action(fn (MenuMenuItem $record) => $record->up())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-up'),
                Tables\Actions\Action::make('order_down')
                    ->iconButton()
                    ->action(fn (MenuMenuItem $record) => $record->down())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down')
            ]);
    }
}
