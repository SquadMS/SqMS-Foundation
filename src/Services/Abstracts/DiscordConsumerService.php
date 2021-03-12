<?php

namespace SquadMS\Foundation\Services\Abstracts;

use SquadMS\Foundation\Services\DiscordService;

abstract class DiscordConsumerService {

    protected DiscordService $discordService;
    protected ?int $channelId = null;

    function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }
}