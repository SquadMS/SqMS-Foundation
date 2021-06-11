<?php

namespace SquadMS\Foundation\Console;

use Illuminate\Console\Command;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry;

class Install extends Command
{
    protected $signature = 'sqms:install';

    protected $description = 'Publishes the assets of all installed SquadMS modules.';

    public function handle(SquadMSModuleRegistry $registry)
    {
        $this->info('Setting up the Laravel Project for SquadMS...');

        // AuthenticateSession Middleware...
        $this->replaceInFile(
            '// \Illuminate\Session\Middleware\AuthenticateSession::class',
            '\Laravel\Jetstream\Http\Middleware\AuthenticateSession::class',
            app_path('Http/Kernel.php')
        );

        $this->info('Setup complete!');
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
