<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;

class RefreshService implements UnibetInterface
{
    const REFRESH_URL = 'zones/livebox/overview/refresh.json';

    /**
     * @var Client
     */
    private $unibetApi;

    public function __construct(Client $unibetApi)
    {
        $this->unibetApi = $unibetApi;
    }

    public function refresh(?string $eventId = null): array
    {
        $url = $this->getUrl($eventId);

        $response = $this->unibetApi->get($url);

        return json_decode($response->getBody()->getContents())->rows;
    }

    private function getUrl(?string $eventId = null): string
    {
        if ($eventId) {
            return sprintf('%s%s', self::URL_REFRESH, $eventId);
        }

        return self::URL_REFRESH_ALL;
    }
}
