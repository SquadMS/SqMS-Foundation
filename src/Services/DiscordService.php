<?php

namespace SquadMS\Foundation\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use RestCord\DiscordClient;
use RestCord\RateLimit\Provider\RedisRateLimitProvider;

class DiscordService {

    private DiscordClient $client;

    function __construct()
    {
        /* Initialize the discord client */
        $this->client = new DiscordClient([
            'token' => config('sqms.discord.token'),
            'logger' => Log::getLogger(),
            'rateLimitProvider' => new RedisRateLimitProvider([
                'client' => Redis::connection()->client(),
            ]),
        ]);
    }   

    public function getMessage(int $channel, int $message) : int
    {
        $message = $this->client->channel->getChannelMessage([
            'channel.id' => $channel,
            'message.id' => $message,
        ]);

        return $message->id;
    }

    public function createTextMessage(int $channel, string $content, $file = null) : int
    {
        /** @var \GuzzleHttp\Command\Result */
        $result = $this->client->channel->createMessage([
            'channel.id' => $channel,
            'content'    => $content,
            'file'       => $file,
        ]);

        return Arr::get($result->toArray(), 'id');
    }

    public function createEmbedMessage(int $channel, array $data) : int
    {
        /** @var \GuzzleHttp\Command\Result */
        $result = $this->client->channel->createMessage([
            'channel.id' => $channel,
            'embed'      => $data,
        ]);

        return Arr::get($result->toArray(), 'id');
    }

    public function updateTextMessage(int $channel, int $message, string $content) : int
    {
        $message = $this->client->channel->editMessage([
            'channel.id' => $channel,
            'message.id' => $message,
            'content'    => $content,
            'embed'      => $content,
        ]);
        

        return $message->id;
    }

    public function updateEmbedMessage(int $channel, int $message, array $data) : int
    {
        $message = $this->client->channel->editMessage([
            'channel.id' => $channel,
            'message.id' => $message,
            'content'    => '',
            'embed'      => $data,
        ]);
        

        return $message->id;
    }

    public function deleteMessage(int $channel, int $message) : void
    {
        if ($this->getMessage($channel, $message)) {
            $this->client->channel->deleteMessage([
                'channel.id' => $channel,
                'message.id' => $message,
            ]);
        }
    }

    public function guildUserCount() : int
    {
        $guildId = setting('discord.guild_id');
        if (is_null($guildId)) {
            Log::info('No guild_id configured, cant fetch user count.');
            return 0;
        }

        /* Initialize list of users */
        $list = [];

        $run = true;
        $lastId = null;
        while($run) {
            $parameters = [
                'guild.id' => intval($guildId),
                'limit' => 1000,
            ];

            if ($lastId) {
                $parameters['after'] = $lastId;
            }

            /* Fetch list part */
            $response = $this->client->guild->listGuildMembers($parameters);

            if (!count($response)) {
                /* Terminate loop */
                $run = false;
            } else {
                /* Add users to list */
                $list = array_merge($list, $response);
                $lastId =  end($response)->user->id;
            }            
        }

        return count($list);
    }
}