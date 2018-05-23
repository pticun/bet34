<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;

class EventFactsService implements UnibetInterface
{
    const EVENT_FACTS_URL = 'zones/eventfacts.json?eventId=%s';

    /**
     * @var Client
     */
    private $unibetApi;

    public function __construct(Client $unibetApi)
    {
        $this->unibetApi = $unibetApi;
    }

    public function getEventFacts(string $unibetId): array
    {
        $response = $this->unibetApi->get(sprintf(self::EVENT_FACTS_URL, $unibetId));

        return json_decode($response->getBody()->getContents(), true);
    }
}
