<?php

namespace SquadMS\Foundation\Database\Seeders;

use Illuminate\Database\Seeder;
use SquadMS\Foundation\Database\Seeders\RBACPermissionsSeeder as SeedersRBACPermissionsSeeder;

class SquadMSSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeedersRBACPermissionsSeeder::class,
        ]);
    }
}
