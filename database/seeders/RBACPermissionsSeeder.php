<?php

namespace SquadMS\Foundation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use SquadMS\Foundation\Facades\SquadMSPermissions;

class RBACPermissionsSeeder extends Seeder
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
        foreach (array_keys(SquadMSPermissions::getPermissions()) as $definition) {
            $pairs[] = [
                'name' => $definition,
                'guard_name' => Config::get('auth.defaults.guard', 'web'),
            ];
        }

        /* Mass Update/Insert the Permissions */
        Permission::query()->upsert($pairs, ['name'], ['name']);
    }
}
