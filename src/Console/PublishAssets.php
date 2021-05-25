<?php

namespace SquadMS\Foundation\Console;

use Illuminate\Console\Command;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry;

class PublishAssets extends Command
{
    protected $signature = 'sqms:publish-assets';

    protected $description = 'Publishes the assets of all installed SquadMS modules.';

    public function handle(SquadMSModuleRegistry $registry)
    {
        $this->info('Publishing SquadMS Module assets...');

        $registry->publishAssets();

        $this->info('Publishing complete!');
    }
}