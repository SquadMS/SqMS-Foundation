<?php

namespace SquadMS\Foundation\Filament\Resources\RBACResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use SquadMS\Foundation\Facades\SquadMSPermissions;

class PermissionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'permissions';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * We do only want to manage permissions, not create them
     */
    protected function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $sections = [];

        foreach (SquadMSPermissions::getModules() as $module) {
            $permissions = SquadMSPermissions::getPermissions($module);

            $sections[] = Forms\Components\Section::make($module)->schema([
                Forms\Components\BelongsToManyCheckboxList::make('')
                ->relationship('permissions', 'permissions.name', function (Builder $query) use ($permissions) {
                    return $query->whereIn('permissions.name', array_keys($permissions));
                })
                ->getOptionLabelFromRecordUsing(function (Permission $record) {
                    return Arr::get(SquadMSPermissions::getPermissions(), $record->name, $record->name);
                }),
            ])->collapsible();
        }

        return $form->schema($sections);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
            ])
            ->filters([
                //
            ]);
    }
}
