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
            '\SquadMS\Foundation\Http\Middleware\AuthenticateSession::class',
            app_path('Http/Kernel.php')
        );

        // Use databse session driver
        $this->configureSession();

        $this->info('Setup complete!');
    }

    /**
     * Configure the session driver for Jetstream.
     *
     * @return void
     */
    protected function configureSession()
    {
        if (! class_exists('CreateSessionsTable')) {
            try {
                $this->call('session:table');
            } catch (\Exception $e) {
                //
            }
        }

        $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
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
