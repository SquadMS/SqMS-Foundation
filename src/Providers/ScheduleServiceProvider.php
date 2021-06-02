<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            SquadMSModuleRegistry::runSchedulers($schedule);
        });
    }
}