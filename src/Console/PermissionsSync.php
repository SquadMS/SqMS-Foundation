<?php

namespace SquadMS\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use SquadMS\Foundation\Facades\SquadMSPermissions;

class PermissionsSync extends Command
{
    protected $signature = 'sqms:permissions-sync';

    protected $description = 'Synchronizes the permissions with all installed SquadMS modules.';

    public function handle()
    {
        $this->info('Synchronizing SquadMS permissions...');

        $definitions = SquadMSPermissions::getPermissions();

        /* Properly format the permission definitions array and prefix it with the name key for upserting */
        $pairs = [];
        foreach (array_keys($definitions) as $definition) {
            $pairs[] = [
                'name'       => $definition,
                'guard_name' => Config::get('auth.defaults.guard', 'web'),
            ];
        }

        /* Mass Update/Insert the Permissions */
        Permission::query()->upsert($pairs, ['name'], ['name', 'guard_name']);

        /* Remove obsolete Permissions */
        Permission::whereNotIn('name', array_keys($definitions))->delete();

        /* Clear permissions cache */
        $this->call('permission:cache-reset');

        $this->info('Synchronized SquadMS permissions!');
    }
}
