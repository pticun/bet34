<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface;

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

    public function refresh(?string $eventId = null): ResponseInterface
    {
        $url = $this->getUrl($eventId);

        return $this->unibetApi->get($url);
    }

    private function getUrl(?string $eventId = null): string
    {
        if ($eventId) {
            return sprintf('%s%s', self::URL_REFRESH, $eventId);
        }

        return self::URL_REFRESH_ALL;
    }
}
