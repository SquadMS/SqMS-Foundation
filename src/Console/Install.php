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
        $this->replaceInFile("/'SESSION_DRIVER', '.*'/m", "'SESSION_DRIVER', 'database'", config_path('session.php'), true);
        $this->replaceInFile('/^SESSION_DRIVER=file/m', 'SESSION_DRIVER=database', base_path('.env'), true);
        $this->replaceInFile('/^SESSION_DRIVER=file/m', 'SESSION_DRIVER=database', base_path('.env.example'), true);
    }

    /**
     * Replace a given string within a given file.
     */
    protected function replaceInFile(string $search, string $replace, string $path, bool $regex = false): void
    {
        $original = file_get_contents($path);
        if ($regex) {
            $modified = preg_replace($search, $replace, $original);
        } else {
            $modified = str_replace($search, $replace, $original);
        }

        file_put_contents($path, $modified ?? $original);
    }
}
