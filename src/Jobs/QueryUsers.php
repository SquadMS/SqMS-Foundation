<?php

namespace SquadMS\Foundation\Jobs;

use SquadMS\Foundation\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \skyraptor\LaravelSteamLogin\SteamUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Helpers\UserHelper;

class QueryUsers implements ShouldQueue
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
        $this->steamIDs = is_null($steamIDs) ? self::getUnfetchedSteamIDs() : self::excludeFetchedSteamIDs($steamIDs);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* Query Steam API with bulk steamIDs and bulk create or update them */
        UserService::createOrUpdateBulk(Steamuser::userInfoBulk($this->steamIDs));
    }

    /**
     * Removes steamIds from the provided array that have already been fetched.
     *
     * @param array $steamIDs
     * @return array
     */
    static function excludeFetchedSteamIDs(array $steamIDs) : array
    {
        return UserHelper::getUserModel()->query()->whereIn('steam_id_64', $steamIDs)->where(function(Builder $q) {
            $q->whereNull('last_fetched')->orWhere('last_fetched', '<=', Carbon::now()->subHours(Config::get('sqms.user.fetch_interval', 12)));
        })->pluck('steam_id_64')->toArray();
    }

    /**
     * Get 100 users that have not been fetched for 12 Hours or provided list.
     */
    static function getUnfetchedSteamIDs() : array
    {
        return UserHelper::getUserModel()->query()->whereNull('last_fetched')->orWhere('last_fetched', '<=', Carbon::now()->subHours(Config::get('sqms.user.fetch_interval', 12)))->orderBy('last_fetched')->limit(1000)->pluck('steam_id_64')->toArray();
    }
}