<?php

namespace App\Mock\Unibet;

use App\Service\Unibet\RefreshService as BaseRefreshService;
use GuzzleHttp\Client;

class RefreshService extends BaseRefreshService
{
    const JSON_REFRESH_FILE_PATH = '%s/refresh.json';

    public function __construct(Client $unibetApi)
    {
        parent::__construct($unibetApi);
    }

    public function refresh(?string $eventId = null): array
    {
        $str = file_get_contents(sprintf(self::JSON_REFRESH_FILE_PATH, __DIR__));

        return (json_decode($str))->rows;
    }
}
