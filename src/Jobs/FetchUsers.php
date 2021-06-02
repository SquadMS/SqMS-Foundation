<?php

namespace SquadMS\Foundation\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \skyraptor\LaravelSteamLogin\SteamUser;
use SquadMS\Foundation\Repositories\UserRepository;

class FetchUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $steamIDs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?array $steamIDs = null)
    {
        $this->steamIDs = is_null($steamIDs) ? UserRepository::getUnfetchedSteamIDs() : UserRepository::excludeFetchedSteamIDs($steamIDs);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* Query Steam API with bulk steamIDs and bulk create or update them */
        UserRepository::createOrUpdateBulk(Steamuser::userInfoBulk($this->steamIDs));
    }
}