<?php

namespace SquadMS\Foundation\Auth;

use Carbon\Carbon;
use SquadMS\Foundation\Models\User;

class SteamUserRepository
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
                'avatar_small'
            ]);
        }

        return User::upsert($rows, ['steam_account_id'], $updateRows);
    }

    public static function createOrUpdate(SteamUser $steamUser, bool $shallow = false) : User
    {
        return User::updateOrCreate([
            'steam_account_id' => $steamUser->accountId,
        ], self::createUserData($steamUser, !$shallow));
    }

    public static function createUserData(SteamUser $steamUser, bool $fetch = true) : array
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
            if (!self::isFetched($steamUser)) {
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

    private static function isFetched(SteamUser $steamUser) : bool
    {
        return !is_null($steamUser->name) && !is_null($steamUser->avatar) && !is_null($steamUser->avatarMedium) && !is_null($steamUser->avatarSmall);
    }
}