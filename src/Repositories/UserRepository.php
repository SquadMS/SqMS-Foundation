<?php

namespace SquadMS\Foundation\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use SquadMS\Foundation\Auth\SteamUser;
use SquadMS\Foundation\Models\SquadMSUser;

class UserRepository
{
    public static function createOrUpdateBulk(array $steamUsers, bool $shallow = false)
    {
        $rows = [];

        /** @var \SquadMS\Foundation\Auth\SteamUser $steamUser */
        foreach ($steamUsers as $steamUser) {
            $rows[] = self::createUserData($steamUser, !$shallow);
        }

        $updateRows = [
            'steam_account_url',
            'steam_account_id',
            'steam_id_64',
            'steam_id_2',
            'steam_id_3',
        ];

        if (!$shallow) {
            $updateRows = array_merge($updateRows, [
                'name',
                'avatar',
                'avatar_medium',
                'avatar_small',
            ]);
        }

        return SquadMSUser::upsert($rows, ['steam_account_id'], $updateRows);
    }

    public static function createOrUpdate(SteamUser $steamUser, bool $shallow = false): SquadMSUser
    {
        return SquadMSUser::updateOrCreate([
            'steam_account_id' => $steamUser->accountId,
        ], self::createUserData($steamUser, !$shallow));
    }

    public static function createUserData(SteamUser $steamUser, bool $fetch = true): array
    {
        /* Initialize a data badge with all required parameters, these can be computed from the single steamId */
        $data = [
            'steam_account_url' => $steamUser->accountUrl,
            'steam_account_id'  => $steamUser->accountId,
            'steam_id_64'       => $steamUser->steamId,
            'steam_id_2'        => $steamUser->steamId2,
            'steam_id_3'        => $steamUser->steamId3,
        ];

        if ($fetch) {
            /* Fetch the User from the SteamAPI if it is not already fetched */
            if (!$steamUser->isFetched()) {
                $steamUser->getUserInfo();
            }

            /* Add the fetched information to the data badge, also set the last_fetched attribute */
            $data = array_merge($data, [
                'name'          => $steamUser->name,
                'avatar'        => $steamUser->avatar,
                'avatar_medium' => $steamUser->avatarMedium,
                'avatar_small'  => $steamUser->avatarSmall,
                'last_fetched'  => Carbon::now(),
            ]);
        }

        /* Return the created data badge */
        return $data;
    }

    /**
     * Get 100 users that have not been fetched for 12 Hours or provided list.
     */
    public static function getUnfetchedSteamIDs(): array
    {
        return SquadMSUser::whereNull('last_fetched')
                                       ->orWhere('last_fetched', '<=', Carbon::now()->subHours(Config::get('sqms.user.fetch_interval')))
                                       ->orderBy('last_fetched')
                                       ->limit(1000) // Max limit for the SteamAPI
                                       ->pluck('steam_id_64')
                                       ->toArray();
    }

    public static function excludeFetchedSteamIDs(array $steamIDs): array
    {
        return SquadMSUser::whereIn('steam_id_64', $steamIDs)->where(function (Builder $q) {
            $q->whereNull('last_fetched')->orWhere('last_fetched', '<=', Carbon::now()->subHours(Config::get('sqms.user.fetch_interval')));
        })->pluck('steam_id_64')->toArray();
    }
}
