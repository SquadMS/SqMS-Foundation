<?php

namespace SquadMS\Foundation\Console;

use Illuminate\Console\Command;

class DevPostInstall extends Command
{
    protected $signature = 'dev:post-install';

    protected $description = 'Runs Commands inside the setup dev environment after each composer install/update.';

    public function handle()
    {
        if (env('LARAVEL_SAIL', 0)) {
            $this->info('Detected dev environment / SAIL, running dev commands');

            /* Run commands */
            $this->call('sqms:permissions-sync');
            $this->call('sqms:publish-assets');
            
            $this->call('filament:upgrade');
            $this->call('vendor:publish', [
                '-tag' => 'filament-navigation-assets'
            ]);

            $this->info('Ran all automated dev commands!');
        }
    }
}
