<?php

namespace SquadMS\Foundation\Providers;

use App\Jobs\FetchUsers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            /* Fetch unfetched or outdated users */
            $schedule->job(new FetchUsers())->withoutOverlapping()->everyFiveMinutes();
        });
    }

    public function register()
    {
        //
    }
}