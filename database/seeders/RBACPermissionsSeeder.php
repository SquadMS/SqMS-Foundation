<?php

namespace SquadMS\Foundation\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use SquadMS\Foundation\Facades\SquadMSPermissions;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* Properly format the permission definitions array and prefix it with the name key for upserting */
        $pairs = [];
        foreach (SquadMSPermissions::getPermissions() as $definition) {
            $pairs[] = [
                'name' => $definition,
            ];
        }

        /* Mass Update/Insert the Permissions */
        Permission::query()->upsert($pairs, ['name'], ['name']);
    }
}
